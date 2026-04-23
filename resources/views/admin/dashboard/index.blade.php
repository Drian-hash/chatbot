@extends('admin.dashboard')

@section('admin')
    <main class="main">

        <h2>Dashboard</h2>


        <!-- Cards -->
        <div class="cards">
            <div class="card">
                <h4>Total Pesan</h4>
                <h2>12,543</h2>
                <p class="up">+12.5% vs minggu lalu</p>
            </div>

            <div class="card">
                <h4>Pengguna Aktif</h4>
                <h2>2,847</h2>
                <p class="up">+8.2%</p>
            </div>

            <div class="card">
                <h4>Tingkat Respons</h4>
                <h2>94.3%</h2>
                <p class="down">-2.1%</p>
            </div>

            <div class="card">
                <h4>Waktu Respons</h4>
                <h2>1.2 detik</h2>
                <p class="up">-15.3%</p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="content">
            <div class="chart-box">
                <h3>Tren Pesan (7 Hari Terakhir)</h3>
                <div class="chart-placeholder">[ Grafik Line di sini ]</div>
            </div>

            <div class="chart-box">
                <h3>Kategori Pertanyaan</h3>
                <div class="chart-placeholder">[ Pie Chart di sini ]</div>
            </div>
        </div>

    </main>
@endsection
