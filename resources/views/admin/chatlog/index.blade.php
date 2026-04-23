@extends('admin.dashboard')

@section('title', 'Chat Log')

@section('admin')

    <style>
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
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .right-actions {
            display: flex;
            gap: 10px;
        }

        .right-actions input {
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 220px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            font-weight: 600;
        }

        td,
        th {
            padding: 12px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            background: #e0f2fe;
            color: #0284c7;
        }

        .chat-user {
            font-weight: 600;
        }

        .chat-message {
            color: #444;
        }

        .chat-reply {
            color: #16a34a;
        }

        /* PAGINATION */
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
            cursor: default;
        }

        .pagination-current {
            padding: 6px 12px;
            border-radius: 6px;
            background: #38bdf8;
            color: white;
            font-weight: 500;
        }
    </style>

    <h2 class="title">Chat Log</h2>

    <div class="table-box">

        <!-- HEADER -->
        <div class="table-header">

            <div></div>

            <div class="right-actions">
                <form method="GET">
                    <input type="text" name="search" placeholder="Cari chat / user..." value="{{ request('search') }}">
                </form>
            </div>

        </div>

        <!-- TABLE -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Pesan</th>
                    <th>Balasan</th>
                    <th>Waktu</th>
                </tr>
            </thead>

            <tbody>
                @forelse($chatlog as $item)
                    <tr>
                        <td>{{ ($chatlog->currentPage() - 1) * $chatlog->perPage() + $loop->iteration }}</td>

                        <td>
                            <div class="chat-user">
                                {{ $item->user->name ?? 'User' }}
                            </div>
                            <small>{{ $item->user->phone ?? '-' }}</small>
                        </td>

                        <td class="chat-message">
                            {{ $item->message }}
                        </td>

                        <td class="chat-reply">
                            {{ $item->reply ?? '-' }}
                        </td>

                        <td>
                            {{ $item->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:30px;color:#999;">
                            Belum ada chat
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="pagination-container">

            <!-- INFO -->
            <div class="pagination-info">
                Menampilkan {{ $chatlog->firstItem() ?? 0 }} - {{ $chatlog->lastItem() ?? 0 }}
                dari {{ $chatlog->total() }} data
            </div>

            <!-- BUTTON -->
            <div class="pagination-custom">

                {{-- PREVIOUS --}}
                @if ($chatlog->onFirstPage())
                    <span class="pagination-btn disabled">&#8249;</span>
                @else
                    <a href="{{ $chatlog->previousPageUrl() }}&search={{ request('search') }}"
                        class="pagination-btn">&#8249;</a>
                @endif

                {{-- CURRENT PAGE --}}
                <span class="pagination-current">
                    {{ $chatlog->currentPage() }}
                </span>

                {{-- NEXT --}}
                @if ($chatlog->hasMorePages())
                    <a href="{{ $chatlog->nextPageUrl() }}&search={{ request('search') }}"
                        class="pagination-btn">&#8250;</a>
                @else
                    <span class="pagination-btn disabled">&#8250;</span>
                @endif

            </div>

        </div>

    </div>

@endsection
