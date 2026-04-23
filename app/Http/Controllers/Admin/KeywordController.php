<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    /**
     * 📋 LIST DATA
     */
    public function index(Request $request)
    {
        $query = Keyword::query();

        // 🔍 SEARCH
        if ($request->search) {
            $query->where('kata_kunci', 'like', '%' . $request->search . '%');
        }

        $keyword = $query->orderBy('id', 'asc')->paginate(10);

        return view('admin.keyword.index', compact('keyword'));
    }

    /**
     * ➕ STORE
     */
    public function store(Request $request)
    {
        $request->validate([
            'kata_kunci' => 'required|string|max:255',
            'jawaban' => 'required|string'
        ]);

        Keyword::create([
            'kata_kunci' => strtolower($request->kata_kunci), // 🔥 normalize
            'jawaban' => $request->jawaban
        ]);

        return redirect()->route('admin.keyword.index')
            ->with('success', 'Keyword berhasil ditambahkan');
    }

    /**
     * ✏️ UPDATE
     */
    public function update(Request $request, $id)
    {
        $data = Keyword::findOrFail($id);

        $request->validate([
            'kata_kunci' => 'required|string|max:255',
            'jawaban' => 'required|string'
        ]);

        $data->update([
            'kata_kunci' => strtolower($request->kata_kunci), // 🔥 konsisten
            'jawaban' => $request->jawaban
        ]);

        return redirect()->route('admin.keyword.index')
            ->with('success', 'Keyword berhasil diupdate');
    }

    /**
     * 🗑️ DELETE
     */
    public function destroy($id)
    {
        $data = Keyword::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.keyword.index')
            ->with('success', 'Keyword berhasil dihapus');
    }
}
