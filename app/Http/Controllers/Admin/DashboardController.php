<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TteRequest;
use App\Models\IkasandiPertanyaan;
use App\Models\Berita;


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
}
