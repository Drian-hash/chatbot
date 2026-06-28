<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Faq;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * =====================================================
     * 🌐 ENDPOINT WEBHOOK WHATSAPP (FONNTE)
     * =====================================================
     */
    public function webhook(Request $request)
    {
        // 1. Ambil data pengirim dan pesan masuk
        $sender = $request->input('sender');
        $message = trim($request->input('message'));
        $lowerMessage = strtolower($message);

        if (empty($message)) return response()->json(['status' => 'ignored']);

        // Ambil status menu terakhir user dari Cache
        $sessionState = Cache::get('bot_state_' . $sender, 'AWAL');

        // =================================================================
        // NAVIGATION HANDLER: KEYWORD 'MENU' / 'KEMBALI' (GLOBAL RESET)
        // =================================================================
        if ($lowerMessage === 'menu' || $lowerMessage === 'kembali') {
            Cache::put('bot_state_' . $sender, 'AWAL', 600);
            Cache::forget('active_layanan_id_' . $sender);
            return $this->sendWhatsApp($sender, $this->getMenuUtamaText());
        }

        // =================================================================
        // HANDLER INPUT ANGKA (NAVIGASI MENU)
        // =================================================================
        if (is_numeric($message)) {
            $nomorMenu = (int)$message;

            // --- TOMBOL 0: LOGIKA MUNDUR/ROLLBACK ---
            if ($nomorMenu === 0) {
                if ($sessionState === 'MEMBACA_DESKRIPSI') {
                    // Jika sedang baca detail layanan, kembali ke Daftar 21 Layanan
                    Cache::put('bot_state_' . $sender, 'LIHAT_LIST_LAYANAN', 600);
                    Cache::forget('active_layanan_id_' . $sender);
                    return $this->sendWhatsApp($sender, $this->getListLayananText());
                } else {
                    // Jika di posisi lain, kembali ke Menu Utama Induk (1,2,3)
                    Cache::put('bot_state_' . $sender, 'AWAL', 600);
                    Cache::forget('active_layanan_id_' . $sender);
                    return $this->sendWhatsApp($sender, $this->getMenuUtamaText());
                }
            }

            // --- MENU UTAMA INDUK (AWAL) ---
            if ($sessionState === 'AWAL') {
                if ($nomorMenu === 1) {
                    Cache::put('bot_state_' . $sender, 'LIHAT_LIST_LAYANAN', 600);
                    return $this->sendWhatsApp($sender, $this->getListLayananText());
                } elseif ($nomorMenu === 2) {
                    return $this->sendWhatsApp($sender, "📝 *Ajukan Permohonan*\n\nSilakan kunjungi link berikut untuk mengajukan permohonan baru: https://silapu.ketapangkab.go.id/permohonan\n\n────────────────\n🏠 Ketik *Menu* untuk kembali.");
                } elseif ($nomorMenu === 3) {
                    return $this->sendWhatsApp($sender, "🔍 *Cek Status*\n\nSilakan masukkan Nomor Tiket/Resi permohonan Kitak untuk melakukan pelacakan status berkas.");
                }
            }

            // --- PILIHAN LAYANAN (1 - 21) ---
            if ($sessionState === 'LIHAT_LIST_LAYANAN' || $sessionState === 'MEMBACA_DESKRIPSI') {
                if ($nomorMenu >= 1 && $nomorMenu <= 21) {
                    $allLayanans = Layanan::orderBy('id', 'asc')->get();
                    $layananDipilih = $allLayanans->get($nomorMenu - 1);

                    if ($layananDipilih) {
                        Cache::put('bot_state_' . $sender, 'MEMBACA_DESKRIPSI', 600);
                        Cache::put('active_layanan_id_' . $sender, $layananDipilih->id, 600);

                        $replyText = "📄 *DESKRIPSI: " . strtoupper($layananDipilih->nama_layanan) . "*\n\n";
                        $replyText .= $layananDipilih->deskripsi ?? "Penjelasan belum tersedia.";
                        $replyText .= "\n\n────────────────\n";
                        $replyText .= "💡 *Ada yang ingin ditanyakan terkait layanan ini?* Ketik saja pertanyaannya.\n\n";
                        $replyText .= "🔙 *0* . Kembali ke Daftar Layanan\n";
                        $replyText .= "🏠 *MENU* . Menu Utama";

                        return $this->sendWhatsApp($sender, $replyText);
                    }
                }
            }
        }

        // =================================================================
        // JALUR NLP: BYPASS KE GEMINI AI (JIKA BUKAN NAVIGASI ANGKA)
        // =================================================================
        return $this->handleNlpResponse($sender, $message);
    }

    /**
     * FUNGSI BYPASS KE GEMINI
     */
    private function handleNlpResponse($sender, $message)
    {
        $activeLayananId = Cache::get('active_layanan_id_' . $sender);
        $konteks = "";

        if ($activeLayananId) {
            $layananSekarang = Layanan::find($activeLayananId);
            if ($layananSekarang) {
                $konteks = "USER SEDANG MEMBACA LAYANAN: " . $layananSekarang->nama_layanan . ". Jawab pertanyaan ini dalam konteks layanan tersebut.\n";
            }
        }

        $allFaq = Faq::with('layanan')->get();
        $prompt = "Anda asisten Diskominfo Ketapang. Jawab pertanyaan warga berdasarkan FAQ ini: " . json_encode($allFaq) . ". " . $konteks . " Jawaban harus ramah, pakai sapaan 'Kitak', dan berikan navigasi penutup: '\n\n────────────────\n🏠 Ketik *Menu* untuk kembali'.";

        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . env('GEMINI_API_KEY');
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post($url, ['contents' => [['role' => 'user', 'parts' => [['text' => $prompt . "\nPertanyaan: " . $message]]]]]);

            $botResponse = $response->json('candidates.0.content.parts.0.text');
            return $this->sendWhatsApp($sender, $botResponse ?? "Maaf, sistem sedang sibuk. Ketik *Menu*.");
        } catch (\Exception $e) {
            return $this->sendWhatsApp($sender, "Maaf, kendala sistem. Ketik *Menu*.");
        }
    }

    private function getMenuUtamaText()
    {
        return "🤖 *MENU UTAMA SISTEM INFORMASI*\n\n" .
               "1️⃣ Informasi Jenis Pelayanan\n" .
               "2️⃣ Ajukan Permohonan Baru\n" .
               "3️⃣ Cek Status Pelayanan Berkas\n\n" .
               "🔢 Silakan ketik angka *1*, *2*, atau *3* untuk memilih.\n" .
               "➡️ Ketik *0* kapan saja untuk kembali.";
    }

    private function getListLayananText()
    {
        $layanans = Layanan::orderBy('id', 'asc')->get();
        $text = "📢 *DAFTAR LAYANAN DISKOMINFO*\n\n";
        foreach ($layanans as $index => $item) {
            $text .= ($index + 1) . ". " . $item->nama_layanan . "\n";
        }
        $text .= "\n👉 Ketik *Nomor Urut* untuk detail.\n🔙 Ketik *0* untuk kembali ke Menu Utama.";
        return $text;
    }

    private function sendWhatsApp($target, $message)
    {
        Http::withHeaders(['Authorization' => env('FONNTE_TOKEN')])
            ->post('https://api.fonnte.com/send', ['target' => $target, 'message' => $message]);
        return response()->json(['status' => 'sent']);
    }
}
