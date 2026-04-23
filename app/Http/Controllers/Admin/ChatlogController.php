<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatLog;
use App\Models\Layanan;
use Illuminate\Http\Request;

class ChatLogController extends Controller
{
    /**
     * 📋 LIST DATA CHAT
     */
    public function index(Request $request)
    {
        $query = ChatLog::with(['user', 'faq', 'layanan']);

        // 🔍 SEARCH (pesan / balasan / nomor user)
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

        $chatlog = $query->latest()->paginate(10);
        $layanan = Layanan::all();

        return view('admin.chatlog.index', compact('chatlog', 'layanan'));
    }

    /**
     * 🗑️ DELETE (optional)
     */
    public function destroy($id)
    {
        $chat = ChatLog::findOrFail($id);
        $chat->delete();

        return redirect()->route('admin.chatlog.index')
            ->with('success', 'Chat berhasil dihapus');
    }

    /**
     * 🧹 CLEAR ALL (optional fitur)
     */
    public function clear()
    {
        ChatLog::truncate();

        return redirect()->route('admin.chatlog.index')
            ->with('success', 'Semua chat berhasil dihapus');
    }
}
