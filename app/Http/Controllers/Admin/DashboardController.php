<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TteRequest;
use App\Models\IkasandiPertanyaan;
use App\Models\Berita;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalTte = TteRequest::count();
        $totalIkasandi = IkasandiPertanyaan::count();
        $totalBerita = Berita::count();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalTte',
            'totalIkasandi',
            'totalBerita'
        ));
    }

    public function chartTte(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $data = TteRequest::selectRaw("
        MONTH(timestamp) as bulan,
        SUM(CASE WHEN jenis_permohonan = 'Permohonan TTE Baru (Belum Mempunyai TTE)' THEN 1 ELSE 0 END) as baru,
        SUM(CASE WHEN jenis_permohonan = 'Lupa Passphrase TTE' THEN 1 ELSE 0 END) as lupa,
        SUM(CASE WHEN jenis_permohonan = 'Pembaharuan TTE ( TTE Expired)' THEN 1 ELSE 0 END) as expired
    ")
            ->whereYear('timestamp', $tahun)
            ->groupByRaw('MONTH(timestamp)')
            ->orderByRaw('MONTH(timestamp)')
            ->get();

        $baru = array_fill(0, 12, 0);
        $lupa = array_fill(0, 12, 0);
        $expired = array_fill(0, 12, 0);

        foreach ($data as $row) {

            $index = $row->bulan - 1;

            $baru[$index] = $row->baru;
            $lupa[$index] = $row->lupa;
            $expired[$index] = $row->expired;
        }

        return response()->json([
            'baru' => $baru,
            'lupa' => $lupa,
            'expired' => $expired
        ]);
    }

    public function chartBerita(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $data = Berita::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $result = array_fill(0, 12, 0);

        foreach ($data as $bulan => $total) {
            $result[$bulan - 1] = $total;
        }

        return response()->json([
            'berita' => $result
        ]);
    }
}
