<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Layanan;
use App\Models\ChatLog;
use App\Models\Faq;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input filter atau gunakan default (Bulan & Tahun Sekarang)
        $selectedMonth = $request->get('month', date('m'));
        $selectedYear  = $request->get('year', date('Y'));

        // 2. Buat list filter 3 tahun ke depan (2026, 2027, 2028)
        $availableYears = [2026, 2027, 2028];

        // 3. Buat daftar tanggal lengkap pada bulan yang dipilih (Sumbu X)
        $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->daysInMonth;
        $days = collect(range(1, $daysInMonth))->map(function($day) use ($selectedYear, $selectedMonth) {
            return Carbon::createFromDate($selectedYear, $selectedMonth, $day)->format('Y-m-d');
        });

        // 4. Ambil data ChatLog yang difilter berdasarkan Bulan dan Tahun pilihan
        $chatDataRaw = ChatLog::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereMonth('created_at', $selectedMonth)
            ->whereYear('created_at', $selectedYear)
            ->groupBy('date')
            ->pluck('total', 'date');

        // 5. Petakan data agar tanggal kosong di DB tetap bernilai 0
        $chartChats = $days->map(fn($date) => $chatDataRaw[$date] ?? 0)->toArray();

        // 6. Format Label Sumbu X (Contoh: "01", "02", "03", dst)
        $chartLabels = $days->map(fn($date) => date('d', strtotime($date)))->toArray();

        return view('admin.dashboard.index', [
            // 🔥 DATA CARD
            'totalUsers'    => User::count(),
            'totalPesan'    => ChatLog::count(),
            'totalFaq'      => Faq::count(),
            'totallayanan'  => Layanan::count(),

            // 📊 DATA GRAFIK & FILTER
            'chartLabels'   => $chartLabels,
            'chartChats'    => $chartChats,
            'selectedMonth' => $selectedMonth,
            'selectedYear'  => $selectedYear,
            'availableYears'=> $availableYears,
        ]);
    }
}
