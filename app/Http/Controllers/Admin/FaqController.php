<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FaqImport; // Menggunakan satu-satunya library import pilihan Anda

class FaqController extends Controller
{
    /**
     * =====================================================
     * 📋 TAMPILAN UTAMA & PENCARIAN DATA FAQ
     * =====================================================
     */
    public function index(Request $request)
    {
        $query = Faq::with('layanan');

        // Fitur Pencarian Data
        if ($request->search) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%');
        }

        // Ambil jumlah data per halaman (default: 10 entries)
        $perPage = $request->get('per_page', 10);

        $faq = $query->orderBy('id', 'asc')->paginate($perPage)->withQueryString();
        $layanan = Layanan::all();

        return view('admin.faq.index', compact('faq', 'layanan'));
    }

    /**
     * =====================================================
     * ➕ SIMPAN DATA FAQ BARU (MANUAL)
     * =====================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string'
        ]);

        Faq::create([
            'layanan_id' => $request->layanan_id,
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil ditambahkan');
    }

    /**
     * =====================================================
     * ✏️ UPDATE / PERBARUI DATA FAQ
     * =====================================================
     */
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string'
        ]);

        $faq->update([
            'layanan_id' => $request->layanan_id,
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
        ]);

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil diupdate');
    }

    /**
     * =====================================================
     * 🗑️ HAPUS PERMANEN DATA FAQ
     * =====================================================
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', 'FAQ berhasil dihapus');
    }

    /**
     * =====================================================
     * 📥 DIRECT DATA IMPORT: EXCEL & CSV MANIFEST
     * =====================================================
     */
    public function import(Request $request)
    {
        // Validasi ekstensi file hanya menerima format Excel dan CSV saja (Maksimal 4MB)
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:4096'
        ]);

        try {
            // Mengeksekusi file import langsung menggunakan class FaqImport pilihan Anda
            Excel::import(new FaqImport, $request->file('file'));

            return redirect()->route('admin.faq.index')
                ->with('success', 'Seluruh data berkas FAQ berhasil diimport dari berkas Excel/CSV ke dalam sistem.');

        } catch (\Exception $e) {
            // Mengamankan crash database apabila struktur kolom di Excel admin tidak sesuai template
            return redirect()->back()->with('error', 'Gagal memproses berkas Excel. Pastikan format tabel dan data layanan_id Anda sudah sesuai.');
        }
    }
}
