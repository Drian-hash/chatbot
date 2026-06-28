<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatLog;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;

class ChatLogController extends Controller
{
    /**
     * 📋 LIST DATA CHAT (INBOX STYLE - 1 PESAN TERAKHIR PER USER)
     */
    public function index(Request $request)
    {
        // 1. Ambil ID chat paling terbaru (MAX id) untuk masing-masing user_id
        $latestChatIds = ChatLog::selectRaw('MAX(id) as id')
            ->groupBy('user_id');

        // 2. Tarik data lengkap berdasarkan kumpulan ID terbaru di atas
        $query = ChatLog::whereIn('id', $latestChatIds)->with(['user', 'faq', 'layanan']);

        // 🔍 SEARCH (pesan / balasan / nama / nomor user)
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('message', 'like', "%$search%")
                  ->orWhere('reply', 'like', "%$search%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%");
                  });
            });
        }

        // 🔽 FILTER LAYANAN
        if ($request->layanan_id) {
            $query->where('layanan_id', $request->layanan_id);
        }

        // 🔽 FILTER FAQ
        if ($request->faq_id) {
            $query->where('faq_id', $request->faq_id);
        }

        // Urutkan dari percakapan yang paling baru berinteraksi
        $chatlog = $query->orderBy('id', 'desc')->paginate(10);
        $layanan = Layanan::all();

        return view('admin.chatlog.index', compact('chatlog', 'layanan'));
    }

    /**
     * 💬 AJAX ROOM: AMBIL SELURUH RIWAYAT CHAT USER (UNTUK GELEMBUNG CHAT)
     */
    public function getHistory($userId)
    {
        $user = User::findOrFail($userId);

        // Ambil semua riwayat chat milik user tersebut, urutkan dari terlama ke terbaru
        $history = ChatLog::where('user_id', $userId)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($chat) {
                return [
                    'message'    => $chat->message,
                    'reply'      => $chat->reply,
                    'time_chat'  => $chat->created_at->format('H:i'),
                    'date_chat'  => $chat->created_at->format('d M Y'),
                ];
            });

        return response()->json([
            'status'  => 'success',
            'user'    => [
                'name'  => $user->name,
                'phone' => $user->phone,
            ],
            'history' => $history
        ]);
    }

    /**
     * 🗑️ DELETE PER CAKAPAN USER (MENGHAPUS SELURUH LOG USER TERSEBUT)
     */
    public function destroy($id)
    {
        // Cari log chat terpilih
        $chat = ChatLog::findOrFail($id);

        // Hapus seluruh riwayat percakapan yang memiliki user_id yang sama
        ChatLog::where('user_id', $chat->user_id)->delete();

        return redirect()->route('admin.chatlog.index')
            ->with('success', 'Riwayat percakapan user berhasil dihapus');
    }

    /**
     * 🧹 CLEAR ALL LOG
     */
    public function clear()
    {
        ChatLog::truncate();

        return redirect()->route('admin.chatlog.index')
            ->with('success', 'Semua chatlog berhasil dibersihkan');
    }
}
