<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ChatLog;
use App\Models\Keyword;
use App\Models\Faq;
use App\Models\Layanan;

class ChatbotController extends Controller
{
    // =========================================================
    // 🔥 WEBHOOK FONNTE (MASUK DARI WHATSAPP)
    // =========================================================
    public function webhook(Request $request)
    {
        // 🔥 AMBIL DATA DARI FONNTE
        $phone = $request->input('sender');
        $message = strtolower(trim($request->input('message')));
        $name = 'User';

        // 🔥 VALIDASI
        if (!$phone || !$message) {
            return response()->json(['status' => 'invalid']);
        }

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

        // 🔥 SIMPAN CHAT MASUK
        $chat = ChatLog::create([
            'user_id' => $user->id,
            'message' => $message
        ]);

        // 🔥 AMBIL JAWABAN
        $reply = $this->getReply($message);

        // 🔥 SIMPAN BALASAN
        $chat->update([
            'reply' => $reply
        ]);

        $user->save();

        // 🔥 KIRIM KE WHATSAPP
        $this->sendMessage($phone, $reply);

        return response()->json(['status' => 'success']);
    }

    // =========================================================
    // 🔥 LOGIKA BOT (PRIORITAS DATABASE)
    // =========================================================
    private function getReply($message)
    {
        // 🔹 1. KEYWORD
        $keyword = Keyword::where('kata_kunci', 'like', "%$message%")->first();
        if ($keyword) {
            return $keyword->jawaban;
        }

        // 🔹 2. FAQ
        $faq = Faq::where('pertanyaan', 'like', "%$message%")->first();
        if ($faq) {
            return $faq->jawaban;
        }

        // 🔹 3. LAYANAN
        $layanan = Layanan::where('nama_layanan', 'like', "%$message%")->first();
        if ($layanan) {
            return $layanan->deskripsi;
        }

        // 🔥 4. FALLBACK → MENU LAYANAN
        return $this->menuLayanan();
    }

    // =========================================================
    // 🔥 MENU LAYANAN (JIKA TIDAK PAHAM)
    // =========================================================
    private function menuLayanan()
    {
        $layanans = Layanan::all();

        $text = "Maaf, kami tidak memahami maksud Anda.\n\n";
        $text .= "Silakan pilih layanan berikut:\n\n";

        foreach ($layanans as $i => $layanan) {
            $text .= ($i + 1) . ". " . $layanan->nama_layanan . "\n";
        }

        $text .= "\nKetik nama layanan untuk informasi lebih lanjut.";

        return $text;
    }

    // =========================================================
    // 🔥 KIRIM PESAN KE WHATSAPP (FONNTE)
    // =========================================================
    private function sendMessage($target, $message)
    {
        $token = env('FONNTE_TOKEN');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => $target,
                'message' => $message,
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        curl_exec($curl);
        curl_close($curl);
    }
}
