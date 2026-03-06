<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IkasandiKategori;
use Illuminate\Http\Request;

class IkasandiKategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = IkasandiKategori::query();

        // ===============================
        // SEARCH
        // ===============================
        if ($request->search) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('kode_kategori', 'like', '%' . $search . '%')
                  ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        // ===============================
        // SORTING HIERARKI NUMERIK
        // Support: 1 / 1.1 / 1.1.1 / 2.3.4
        // ===============================
        $kategori = $query
            ->orderByRaw("
                CAST(SUBSTRING_INDEX(kode_kategori, '.', 1) AS UNSIGNED),
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode_kategori, '.', 2), '.', -1) AS UNSIGNED),
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode_kategori, '.', 3), '.', -1) AS UNSIGNED),
                CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode_kategori, '.', 4), '.', -1) AS UNSIGNED)
            ")
            ->paginate(10)
            ->withQueryString();

        return view('admin.ikasandi.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        // ===============================
        // FORMAT INPUT
        // ===============================
        $request->merge([
            'kode_kategori' => strtoupper(trim($request->kode_kategori)),
            'keterangan'    => trim($request->keterangan),
        ]);

        // ===============================
        // VALIDASI
        // ===============================
        $request->validate([
            'kode_kategori' => [
                'required',
                'regex:/^[0-9]+(\.[0-9]+)*$/',
                'unique:ikasandi_kategori,kode_kategori'
            ],
            'keterangan' => [
                'required',
                'unique:ikasandi_kategori,keterangan'
            ],
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.regex'    => 'Format kode harus angka bertingkat. Contoh: 1.1 atau 2.3.4',
            'kode_kategori.unique'   => 'Kode kategori sudah digunakan.',
            'keterangan.required'    => 'Keterangan wajib diisi.',
            'keterangan.unique'      => 'Keterangan sudah digunakan.',
        ]);

        IkasandiKategori::create([
            'kode_kategori' => $request->kode_kategori,
            'keterangan'    => $request->keterangan,
            'is_active'     => true,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = IkasandiKategori::findOrFail($id);

        // ===============================
        // FORMAT INPUT
        // ===============================
        $request->merge([
            'kode_kategori' => strtoupper(trim($request->kode_kategori)),
            'keterangan'    => trim($request->keterangan),
        ]);

        // ===============================
        // VALIDASI
        // ===============================
        $request->validate([
            'kode_kategori' => [
                'required',
                'regex:/^[0-9]+(\.[0-9]+)*$/',
                'unique:ikasandi_kategori,kode_kategori,' . $id
            ],
            'keterangan' => [
                'required',
                'unique:ikasandi_kategori,keterangan,' . $id
            ],
        ], [
            'kode_kategori.required' => 'Kode kategori wajib diisi.',
            'kode_kategori.regex'    => 'Format kode harus angka bertingkat. Contoh: 1.1 atau 2.3.4',
            'kode_kategori.unique'   => 'Kode kategori sudah digunakan.',
            'keterangan.required'    => 'Keterangan wajib diisi.',
            'keterangan.unique'      => 'Keterangan sudah digunakan.',
        ]);

        $kategori->update([
            'kode_kategori' => $request->kode_kategori,
            'keterangan'    => $request->keterangan,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        IkasandiKategori::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
