<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BeritaExport;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode', 'like', '%' . $request->search . '%')
                  ->orWhere('isi_ringkas', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->bulan) {
            $query->whereMonth('tanggal_surat', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('tanggal_surat', $request->tahun);
        }

        $berita = $query->latest()->paginate(10);
        $berita->appends($request->all());

        return view('admin.berita.index', compact('berita'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'kode'           => 'required',
            'nomor_surat'    => 'required',
            'tujuan_surat'   => 'required',
            'tanggal_surat'  => 'required|date',
            'isi_ringkas'    => 'required',
            'keterangan'     => 'nullable',
            'bukti_surat'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $filePath = null;

        if ($request->hasFile('bukti_surat')) {

            $file = $request->file('bukti_surat');

            // Buat nama file unik & aman
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('berita', $fileName, 'public');
        }

        Berita::create([
            'kode'          => $request->kode,
            'nomor_surat'   => $request->nomor_surat,
            'tujuan_surat'  => $request->tujuan_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'isi_ringkas'   => $request->isi_ringkas,
            'keterangan'    => $request->keterangan,
            'bukti_surat'   => $filePath
        ]);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'kode'           => 'required',
            'nomor_surat'    => 'required',
            'tujuan_surat'   => 'required',
            'tanggal_surat'  => 'required|date',
            'isi_ringkas'    => 'required',
            'keterangan'     => 'nullable',
            'bukti_surat'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('bukti_surat')) {

            // Hapus file lama jika ada
            if ($berita->bukti_surat && Storage::disk('public')->exists($berita->bukti_surat)) {
                Storage::disk('public')->delete($berita->bukti_surat);
            }

            $file = $request->file('bukti_surat');

            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('berita', $fileName, 'public');

            $berita->bukti_surat = $filePath;
        }

        $berita->update([
            'kode'          => $request->kode,
            'nomor_surat'   => $request->nomor_surat,
            'tujuan_surat'  => $request->tujuan_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'isi_ringkas'   => $request->isi_ringkas,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->bukti_surat && Storage::disk('public')->exists($berita->bukti_surat)) {
            Storage::disk('public')->delete($berita->bukti_surat);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT
    |--------------------------------------------------------------------------
    */

    public function exportExcel(Request $request)
    {
        return Excel::download(new BeritaExport($request), 'berita.xlsx');
    }
}
