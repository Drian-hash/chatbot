@extends('admin.dashboard')

@section('title', 'Pengguna')

@section('admin')

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .title {
            margin-bottom: 18px;
            font-size: 20px;
            font-weight: 600;
        }

        .table-box {
            background: #fff;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .table-header {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
        }

        .right-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* 🔥 EXPORT STYLE (LIKE IMPORT) */
        .btn-export-outline {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px solid #ddd;
            padding: 9px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-export-outline:hover {
            background: #f9fafb;
        }

        .btn-export-outline i {
            font-size: 12px;
        }

        .right-actions input {
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            font-weight: 600;
            font-size: 13px;
        }

        td,
        th {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        td {
            font-size: 13px;
            line-height: 1.5;
        }

        .badge {
            background: #e0f2fe;
            color: #0284c7;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }

        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 18px;
            font-size: 13px;
        }

        .pagination-info {
            color: #6b7280;
        }

        .pagination-custom {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination-btn {
            padding: 5px 10px;
            border-radius: 6px;
            text-decoration: none;
            color: #555;
            transition: 0.2s;
        }

        .pagination-btn:hover {
            background: #f3f4f6;
        }

        .pagination-btn.disabled {
            color: #bbb;
        }

        .pagination-current {
            padding: 6px 12px;
            border-radius: 6px;
            background: #38bdf8;
            color: white;
            font-weight: 500;
        }
    </style>

    <h2 class="title">Data Pengguna</h2>

    <div class="table-box">

        <!-- HEADER -->
        <div class="table-header">

            <div class="right-actions">

                <!-- 🔥 EXPORT -->
                <a href="{{ route('admin.user.export') }}">
                    <button class="btn-export-outline">
                        <i class="fas fa-download"></i>
                        Export
                    </button>
                </a>

                <!-- 🔥 SEARCH -->
                <form method="GET">
                    <input type="text" name="search" placeholder="Cari pengguna..." value="{{ request('search') }}">
                </form>

            </div>

        </div>

        <!-- TABLE -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No WA</th>
                    <th>Total Pesan</th>
                    <th>Pertama Chat</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $item)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>

                        <td>{{ $item->name ?? 'User' }}</td>

                        <td>{{ $item->phone }}</td>

                        <td>
                            <span class="badge">
                                {{ $item->total_messages }}
                            </span>
                        </td>

                        <td>
                            {{ $item->first_chat_at ? \Carbon\Carbon::parse($item->first_chat_at)->format('d M Y H:i') : '-' }}
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:30px;color:#999;">
                            Belum ada data pengguna
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="pagination-container">

            <div class="pagination-info">
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}
                dari {{ $users->total() }} data
            </div>

            <div class="pagination-custom">

                @if ($users->onFirstPage())
                    <span class="pagination-btn disabled">&#8249;</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}&search={{ request('search') }}"
                        class="pagination-btn">&#8249;</a>
                @endif

                <span class="pagination-current">
                    {{ $users->currentPage() }}
                </span>

                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}&search={{ request('search') }}"
                        class="pagination-btn">&#8250;</a>
                @else
                    <span class="pagination-btn disabled">&#8250;</span>
                @endif

            </div>

        </div>

    </div>

@endsection
