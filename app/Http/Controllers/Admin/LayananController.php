<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * 📄 Tampilkan data layanan (dengan pagination)
     */
    public function index(Request $request)
    {
        $query = Layanan::query();

        if ($request->search) {
            $query->where('nama_layanan', 'like', '%' . $request->search . '%');
        }

        $layanan = $query->orderBy('id', 'asc')->paginate(6);

        return view('admin.layanan.index', compact('layanan'));
    }

    /**
     * ➕ Simpan data layanan
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required',
        ]);

        Layanan::create([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * ✏️ Update data layanan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required',
        ]);

        $layanan = Layanan::findOrFail($id);

        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * 🗑️ Hapus data layanan
     */
    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()
            ->route('admin.layanan.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
