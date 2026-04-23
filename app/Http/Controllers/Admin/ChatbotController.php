<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatLog;
use App\Models\Keyword;
use App\Models\Faq;
use App\Models\Layanan;
use OpenAI;

class ChatbotController extends Controller
{
    public function webhook(Request $request)
    {
        // 🔥 AMBIL DATA DARI WA
        $phone = $request->input('From');
        $message = strtolower($request->input('Body'));
        $name = 'User';

        // 🔥 SIMPAN / CEK USER
        $user = User::firstOrCreate(
            ['phone' => $phone],
            ['name' => $name]
        );

        // 🔥 SET FIRST CHAT
        if (!$user->first_chat_at) {
            $user->first_chat_at = now();
        }

        // 🔥 TAMBAH JUMLAH PESAN
        $user->increment('total_messages');

        // 🔥 SIMPAN CHAT
        $chat = ChatLog::create([
            'user_id' => $user->id,
            'message' => $message
        ]);

        // 🔥 AMBIL JAWABAN (DB + AI MEMORY)
        $reply = $this->getReply($message, $user->id);

        // 🔥 UPDATE REPLY
        $chat->update([
            'reply' => $reply
        ]);

        $user->save();

        // 🔥 BALAS KE WHATSAPP
        return response($reply);
    }

    // =========================================================
    // 🔥 LOGIKA BOT (DATABASE + AI)
    // =========================================================
    private function getReply($message, $userId)
    {
        // 🔹 1. KEYWORD
        $keyword = Keyword::where('kata_kunci', 'like', "%$message%")->first();
        if ($keyword) return $keyword->jawaban;

        // 🔹 2. FAQ
        $faq = Faq::where('pertanyaan', 'like', "%$message%")->first();
        if ($faq) return $faq->jawaban;

        // 🔹 3. LAYANAN
        $layanan = Layanan::where('nama_layanan', 'like', "%$message%")->first();
        if ($layanan) return $layanan->deskripsi;

        // 🔥 4. FALLBACK KE AI + MEMORY
        return $this->askAI($message, $userId);
    }

    // =========================================================
    // 🔥 AI MEMORY (INGAT PERCAKAPAN)
    // =========================================================
    private function askAI($message, $userId)
    {
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        // 🔥 AMBIL 10 CHAT TERAKHIR
        $histories = ChatLog::where('user_id', $userId)
            ->latest()
            ->take(10)
            ->get()
            ->reverse();

        $messages = [];

        // 🔹 SYSTEM ROLE
        $messages[] = [
            'role' => 'system',
            'content' => 'Kamu adalah chatbot resmi Dinas Kominfo Ketapang. Jawab dengan sopan, singkat, dan jelas.'
        ];

        // 🔹 MASUKKAN HISTORY
        foreach ($histories as $chat) {
            $messages[] = [
                'role' => 'user',
                'content' => $chat->message
            ];

            if ($chat->reply) {
                $messages[] = [
                    'role' => 'assistant',
                    'content' => $chat->reply
                ];
            }
        }

        // 🔹 TAMBAH INPUT TERBARU
        $messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        try {
            $response = $client->chat()->create([
                'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                'messages' => $messages,
                'temperature' => 0.5,
            ]);

            return $response->choices[0]->message->content;
        } catch (\Exception $e) {
            return "Maaf, sistem sedang mengalami gangguan.";
        }
    }
}
