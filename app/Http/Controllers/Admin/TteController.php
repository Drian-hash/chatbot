<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TteRequest;
use Illuminate\Http\Request;

use App\Imports\TteImport;
use App\Exports\TteExport;
use Maatwebsite\Excel\Facades\Excel;

class TteController extends Controller
{
    /**
     * Menampilkan semua data permohonan TTE (Search + Filter + Pagination)
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $jenis_permohonan = $request->jenis_permohonan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $tte = TteRequest::query()

            // Search
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'LIKE', "%$search%")
                      ->orWhere('nip', 'LIKE', "%$search%")
                      ->orWhere('opd', 'LIKE', "%$search%")
                      ->orWhere('no_hp', 'LIKE', "%$search%")
                      ->orWhere('jenis_permohonan', 'LIKE', "%$search%");
                });
            })

            // Filter layanan
            ->when($jenis_permohonan, function ($query) use ($jenis_permohonan) {
                $query->where('jenis_permohonan', $jenis_permohonan);
            })

            // Filter bulan
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })

            // Filter tahun
            ->when($tahun, function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun);
            })

            ->latest()
            ->paginate(10);

        // supaya filter tetap terbawa saat pagination
        $tte->appends($request->all());

        return view('admin.tte.index', compact('tte'));
    }

    /**
     * Form tambah data permohonan TTE
     */
    public function create()
    {
        return view('admin.tte.create');
    }

    /**
     * Simpan data permohonan TTE
     */
    public function store(Request $request)
    {
        $request->validate([
            'timestamp'        => 'nullable|date',
            'nama_lengkap'     => 'required|string|max:255',
            'nip'              => 'nullable|string|max:30',
            'opd'              => 'nullable|string|max:255',
            'no_hp'            => 'nullable|string|max:20',
            'jenis_permohonan' => 'required|string|max:255',
        ]);

        TteRequest::create([
            'timestamp'        => $request->timestamp ?? now(),
            'nama_lengkap'     => $request->nama_lengkap,
            'nip'              => $request->nip,
            'opd'              => $request->opd,
            'no_hp'            => $request->no_hp,
            'jenis_permohonan' => $request->jenis_permohonan,
        ]);

        return redirect()->route('admin.tte.index')
            ->with('success', 'Data permohonan TTE berhasil ditambahkan.');
    }

    /**
     * Detail data permohonan TTE
     */
    public function show($id)
    {
        $tte = TteRequest::findOrFail($id);
        return view('admin.tte.show', compact('tte'));
    }

    /**
     * Form edit data permohonan TTE
     */
    public function edit($id)
    {
        $tte = TteRequest::findOrFail($id);
        return view('admin.tte.edit', compact('tte'));
    }

    /**
     * Update data permohonan TTE
     */
    public function update(Request $request, $id)
    {
        $tte = TteRequest::findOrFail($id);

        $request->validate([
            'timestamp'        => 'nullable|date',
            'nama_lengkap'     => 'required|string|max:255',
            'nip'              => 'nullable|string|max:30',
            'opd'              => 'nullable|string|max:255',
            'no_hp'            => 'nullable|string|max:20',
            'jenis_permohonan' => 'required|string|max:255',
        ]);

        $tte->update([
            'timestamp'        => $request->timestamp ?? $tte->timestamp,
            'nama_lengkap'     => $request->nama_lengkap,
            'nip'              => $request->nip,
            'opd'              => $request->opd,
            'no_hp'            => $request->no_hp,
            'jenis_permohonan' => $request->jenis_permohonan,
        ]);

        return redirect()->route('admin.tte.index')
            ->with('success', 'Data permohonan TTE berhasil diupdate.');
    }

    /**
     * Hapus data permohonan TTE
     */
    public function destroy($id)
    {
        $tte = TteRequest::findOrFail($id);
        $tte->delete();

        return redirect()->route('admin.tte.index')
            ->with('success', 'Data permohonan TTE berhasil dihapus.');
    }

    /**
     * Import Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new TteImport, $request->file('file'));

        return redirect()->route('admin.tte.index')
            ->with('success', 'Data permohonan TTE berhasil diimport.');
    }

    /**
     * Export Excel
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new TteExport($request), 'laporan_tte.xlsx');
    }
}
