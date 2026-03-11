<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TteRequest;
use Illuminate\Http\Request;

use App\Exports\TteExport;
use Maatwebsite\Excel\Facades\Excel;

class TteController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | INDEX (Search + Filter + Pagination)
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        $search = $request->search;
        $jenis_permohonan = $request->jenis_permohonan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $tte = TteRequest::query()

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('nama_lengkap', 'LIKE', "%$search%")
                        ->orWhere('nip', 'LIKE', "%$search%")
                        ->orWhere('opd', 'LIKE', "%$search%")
                        ->orWhere('no_hp', 'LIKE', "%$search%")
                        ->orWhere('jenis_permohonan', 'LIKE', "%$search%");

                });

            })

            ->when($jenis_permohonan, function ($query) use ($jenis_permohonan) {

                $query->where('jenis_permohonan', $jenis_permohonan);

            })

            ->when($bulan, function ($query) use ($bulan) {

                $query->whereMonth('created_at', $bulan);

            })

            ->when($tahun, function ($query) use ($tahun) {

                $query->whereYear('created_at', $tahun);

            })

            ->latest()

            ->paginate(10);

        $tte->appends($request->all());

        return view('admin.tte.index', compact('tte'));

    }



    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
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



    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {

        $tte = TteRequest::findOrFail($id);

        return view('admin.tte.show', compact('tte'));

    }



    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
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



    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {

        $tte = TteRequest::findOrFail($id);

        $tte->delete();

        return redirect()->route('admin.tte.index')
            ->with('success', 'Data permohonan TTE berhasil dihapus.');

    }



    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

    public function exportExcel(Request $request)
    {

        return Excel::download(

            new TteExport($request),

            'laporan-permohonan-tte.xlsx'

        );

    }



    /*
    |--------------------------------------------------------------------------
    | PRINT LAPORAN
    |--------------------------------------------------------------------------
    */

    public function print(Request $request)
    {

        $tte = TteRequest::query()

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('nama_lengkap', 'LIKE', "%$request->search%")
                        ->orWhere('nip', 'LIKE', "%$request->search%")
                        ->orWhere('opd', 'LIKE', "%$request->search%");

                });

            })

            ->when($request->jenis_permohonan, function ($query) use ($request) {

                $query->where('jenis_permohonan', $request->jenis_permohonan);

            })

            ->when($request->bulan, function ($query) use ($request) {

                $query->whereMonth('created_at', $request->bulan);

            })

            ->when($request->tahun, function ($query) use ($request) {

                $query->whereYear('created_at', $request->tahun);

            })

            ->latest()

            ->get();

        return view('admin.tte.print', compact('tte'));

    }

}
