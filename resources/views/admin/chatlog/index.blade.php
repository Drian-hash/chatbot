@extends('admin.dashboard')

@section('title', 'Daftar Percakapan')

@section('admin')
    <main class="dashboard-content bg-light text-dark d-flex flex-column" style="height: calc(100vh - 60px); min-height: 600px; overflow: hidden;">
        <div class="container-fluid px-3 px-lg-4 py-3 d-flex flex-column h-100 flex-grow-1">

            {{-- JUDUL UTAMA --}}
            <div class="page-heading mb-3 flex-shrink-0">
                <div class="page-heading-copy">
                    <h3 class="h3 mb-1 text-dark fw-bold" style="color: #0f5132 !important;">Daftar Percakapan</h3>
                    <p class="text-muted small mb-0">Manajemen pesan masuk dan komunikasi dua arah bersama masyarakat.</p>
                </div>
            </div>

            {{-- CONTAINER INTERFACE CHAT PANEL --}}
            <div class="row g-3 flex-grow-1 align-items-stretch mb-2" style="height: calc(100vh - 180px); min-height: 0;">

                <div class="col-12 col-md-4 d-flex flex-column h-100">
                    <div class="card border shadow-sm p-3 d-flex flex-column h-100" style="border-radius: 12px; background-color: #ffffff; overflow: hidden;">

                        {{-- Komponen Pencarian --}}
                        <div class="flex-shrink-0">
                            <form action="{{ route('admin.chatlog.index') }}" method="GET" class="mb-3">
                                <div class="position-relative">
                                    <input type="text" name="search" class="form-control bg-light text-dark border ps-4 small" placeholder="Cari nama, nomor, atau isi chat..." style="border-radius: 8px; height: 38px;" value="{{ request('search') }}">
                                    <i class="bi bi-search position-absolute top-50 translate-middle-y text-muted" style="left: 14px; font-size: 13px;"></i>
                                </div>
                            </form>

                            {{-- Filter Status (UKURAN SUTDAH DIPERKECIL) --}}
                            <div class="d-flex gap-1 mb-3 overflow-auto pb-1" style="scrollbar-width: none;">
                                <a href="{{ route('admin.chatlog.index') }}" class="btn btn-sm btn-light border btn-status-custom {{ !request('status') ? 'active-green text-white' : 'text-secondary' }}">Semua</a>
                                <a href="{{ route('admin.chatlog.index', ['status' => 'Selesai']) }}" class="btn btn-sm btn-light border btn-status-custom {{ request('status') == 'Selesai' ? 'active-green text-white' : 'text-secondary' }}">Selesai</a>
                                <a href="{{ route('admin.chatlog.index', ['status' => 'Pending']) }}" class="btn btn-sm btn-light border btn-status-custom" style="color: #dc3545; border-color: rgba(220, 53, 69, 0.25); @if(request('status') == 'Pending') background-color: #f8d7da !important; font-weight: 600; @endif">Menunggu Admin</a>
                                <a href="{{ route('admin.chatlog.index', ['status' => 'Proses']) }}" class="btn btn-sm btn-light border btn-status-custom" style="color: #0d6efd; border-color: rgba(13, 110, 253, 0.25); @if(request('status') == 'Proses') background-color: #cff4fc !important; font-weight: 600; @endif">Sedang Dilayani</a>
                            </div>
                        </div>

                        {{-- Kotak List User Percakapan --}}
                        <div class="flex-grow-1 overflow-auto pe-1" id="inboxUserList" style="overflow-y: auto;">
                            @forelse($chatlog as $log)
                                @if($log->user)
                                <div class="user-chat-row p-3 mb-2 border border-light shadow-2xs" data-user-id="{{ $log->user->id }}" style="border-radius: 8px; background-color: #f8fafc; cursor: pointer; transition: 0.2s;">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="fw-bold text-dark mb-0" style="font-size: 14px;">{{ $log->user->name }}</div>
                                        <span class="badge {{ ($log->status ?? 'Selesai') == 'Selesai' ? 'bg-success-custom' : 'bg-warning-custom' }} px-2 py-0.5" style="font-size: 10px; border-radius: 4px;">
                                            {{ $log->status ?? 'selesai' }}
                                        </span>
                                    </div>

                                    <div class="text-muted font-monospace mt-0.5" style="font-size: 11.5px;">
                                        <i class="bi bi-whatsapp text-success me-1"></i>{{ $log->user->phone }}
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="small fw-bold text-success" style="font-size: 12px; color: #146c43 !important;">{{ $log->layanan->nama_layanan ?? 'Umum' }}</span>
                                        <span class="text-muted font-monospace small" style="font-size: 11px;">{{ $log->created_at->format('H:i') }}</span>
                                    </div>

                                    <div class="text-truncate text-muted small mt-2 opacity-75 border-top pt-1.5" style="font-size: 12px; max-width: 100%;">
                                        @if(empty($log->message))
                                            <i class="bi bi-reply text-primary me-1"></i> {{ $log->reply }}
                                        @else
                                            {{ $log->message }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @empty
                                <div class="text-center text-muted py-5 small">Belum ada percakapan masuk.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8 d-flex flex-column h-100" style="height: 100%;">

                    {{-- Placeholder Default --}}
                    <div id="chatPlaceholder" class="card border shadow-sm p-5 text-center d-flex flex-column justify-content-center align-items-center flex-grow-1 h-100" style="border-radius: 12px; background-color: #ffffff;">
                        <i class="bi bi-chat-left-dots display-3 text-muted mb-3 opacity-25" style="color: #146c43 !important;"></i>
                        <h5 class="text-dark fw-bold">Pilih Ruang Percakapan</h5>
                        <p class="text-muted small mx-auto" style="max-width: 380px;">Klik salah satu chat di sebelah kiri untuk membaca pesan dan mengirim balasan manual.</p>
                    </div>

                    {{-- Ruang Obrolan Aktif --}}
                    <div id="chatRoomArea" class="card border shadow-sm d-none flex-column h-100" style="border-radius: 12px; background-color: #ffffff; overflow: hidden;">

                        {{-- Header Profil Chat --}}
                        <div class="p-3 d-flex justify-content-between align-items-center border-bottom bg-light flex-shrink-0">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-monospace fw-bold" style="width: 40px; height: 40px; background: linear-gradient(135deg, #146c43, #198754); flex-shrink: 0;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 text-dark fw-bold" id="activeUserName">-</h6>
                                    <small class="text-muted font-monospace" id="activeUserPhone">-</small>
                                </div>
                            </div>
                        </div>

                        {{-- Ruang Riwayat Chat --}}
                        <div class="flex-grow-1 overflow-auto p-4 d-flex flex-column gap-2" id="chatBubbleBody" style="background-color: #efeae2;">
                            </div>

                        {{-- Footer Form Kirim Balasan --}}
                        <div class="p-3 bg-light border-top flex-shrink-0">
                            <form id="formReplyManual" action="" method="POST" class="m-0 d-flex gap-2">
                                @csrf
                                <input type="text" id="inputReplyMessage" name="reply" class="form-control bg-white text-dark border px-3" placeholder="Ketik pesan..." style="border-radius: 8px; height: 42px;" required autocomplete="off">
                                <button type="submit" class="btn btn-success d-flex align-items-center justify-content-center" style="width: 44px; height: 42px; background-color: #146c43; border: none; border-radius: 8px;">
                                    <i class="bi bi-send-fill text-white"></i>
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </main>

    <audio id="notifSound" src="https://assets.mixkit.co/active_storage/sfx/2357/2357-84.wav" preload="auto"></audio>

    {{-- STYLE INTERFACE --}}
    <style>
        /* CSS KHUSUS TOMBOL FILTER DIKECILKAN SEPERTI PERMINTAAN MOCKUP */
        .btn-status-custom {
            border-radius: 20px;
            font-size: 11.5px !important;
            padding: 4px 10px !important;
            height: 28px !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        .btn-status-custom.active-green {
            background-color: #146c43 !important;
            color: #fff !important;
            border-color: #146c43 !important;
        }

        .user-chat-row:hover { background-color: #f1f5f9 !important; border-color: #cbd5e1 !important; }
        .user-chat-row.active { background-color: #e2e8f0 !important; border-left: 4px solid #146c43 !important; }
        .bg-success-custom { background-color: #d1fae5; color: #065f46 !important; border: 1px solid #a7f3d0; }
        .bg-warning-custom { background-color: #fef3c7; color: #92400e !important; border: 1px solid #fde68a; }

        .bubble-user {
            align-self: flex-start; max-width: 65%; background-color: #ffffff;
            color: #111b21; padding: 8px 12px; border-radius: 0px 8px 8px 8px;
            position: relative; box-shadow: 0 1px 1px rgba(0,0,0,0.06); font-size: 14px; border: 1px solid #e2e8f0;
        }
        .bubble-bot {
            align-self: flex-end; max-width: 65%; background-color: #e8f5e9;
            color: #111b21; padding: 8px 12px; border-radius: 8px 0px 8px 8px;
            position: relative; box-shadow: 0 1px 1px rgba(0,0,0,0.06); font-size: 14px; border: 1px solid #cbd5e1;
        }
        .bubble-admin {
            align-self: flex-end; max-width: 65%; background-color: #d9fdd3;
            color: #111b21; padding: 8px 12px; border-radius: 8px 0px 8px 8px;
            position: relative; box-shadow: 0 1px 1px rgba(0,0,0,0.06); font-size: 14px; border: 1px solid #ccebba;
        }
        .chat-time { font-size: 10px; color: #667781; text-align: right; margin-top: 3px; display: block; }
    </style>

    {{-- JAVASCRIPT HANDLER VIA AJAX --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentActiveUserId = null;
        let totalMessagesCached = 0;
        const bubbleBody = document.getElementById('chatBubbleBody');
        const placeholder = document.getElementById('chatPlaceholder');
        const chatRoom = document.getElementById('chatRoomArea');
        const notifSound = document.getElementById('notifSound');

        window.loadChatRoom = function(userId, autoScroll = false) {
            currentActiveUserId = userId;
            document.getElementById('formReplyManual').setAttribute('action', `/admin/percakapan/reply/${userId}`);

            fetch(`/admin/percakapan/history/${userId}`)
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        placeholder.classList.replace('d-flex', 'd-none');
                        chatRoom.classList.replace('d-none', 'd-flex');

                        document.getElementById('activeUserName').innerText = data.user.name;
                        document.getElementById('activeUserPhone').innerText = data.user.phone;

                        if (totalMessagesCached > 0 && data.history.length > totalMessagesCached) {
                            notifSound.play().catch(e => {});
                            autoScroll = true;
                        }
                        totalMessagesCached = data.history.length;

                        bubbleBody.innerHTML = '';

                        data.history.forEach(chat => {
                            if (chat.message) {
                                const bUser = document.createElement('div');
                                bUser.className = 'bubble-user text-start';
                                bUser.innerHTML = `<div>${escapeHtml(chat.message)}</div><span class="chat-time font-monospace">${chat.time_chat}</span>`;
                                bubbleBody.appendChild(bUser);
                            }

                            if (chat.reply) {
                                const bOut = document.createElement('div');
                                bOut.className = chat.is_manual ? 'bubble-admin text-start' : 'bubble-bot text-start';
                                bOut.innerHTML = `<div>${replaceLinebreaks(escapeHtml(chat.reply))}</div><span class="chat-time font-monospace">${chat.time_chat} <i class="bi bi-check2-all text-success"></i></span>`;
                                bubbleBody.appendChild(bOut);
                            }
                        });

                        if (autoScroll) {
                            bubbleBody.scrollTop = bubbleBody.scrollHeight;
                        }
                    }
                });
        };

        function bindRowClick() {
            document.querySelectorAll('.user-chat-row').forEach(row => {
                row.onclick = function() {
                    document.querySelectorAll('.user-chat-row').forEach(r => r.classList.remove('active'));
                    this.classList.add('active');
                    totalMessagesCached = 0;
                    loadChatRoom(this.getAttribute('data-user-id'), true);
                };
            });
        }
        bindRowClick();

        document.getElementById('formReplyManual').onsubmit = function(e) {
            e.preventDefault();
            const inputField = document.getElementById('inputReplyMessage');
            const messageText = inputField.value.trim();
            if(!messageText || !currentActiveUserId) return;

            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    const now = new Date();
                    const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

                    const newBubble = document.createElement('div');
                    newBubble.className = 'bubble-admin text-start';
                    newBubble.innerHTML = `<div>${replaceLinebreaks(escapeHtml(messageText))}</div><span class="chat-time font-monospace">${timeStr} <i class="bi bi-check2-all text-success"></i></span>`;

                    bubbleBody.appendChild(newBubble);
                    inputField.value = '';
                    bubbleBody.scrollTop = bubbleBody.scrollHeight;
                    totalMessagesCached++;
                }
            });
        };

        setInterval(() => {
            if (currentActiveUserId !== null) {
                loadChatRoom(currentActiveUserId, false);
            }

            fetch(window.location.href)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newInboxList = doc.getElementById('inboxUserList').innerHTML;

                    const oldContainer = document.getElementById('inboxUserList');
                    const activeIdBefore = currentActiveUserId;

                    oldContainer.innerHTML = newInboxList;
                    bindRowClick();

                    if (activeIdBefore) {
                        const targetRow = oldContainer.querySelector(`[data-user-id="${activeIdBefore}"]`);
                        if(targetRow) targetRow.classList.add('active');
                    }
                });
        }, 5000);

        function escapeHtml(text) {
            return text ? text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;") : '';
        }
        function replaceLinebreaks(text) {
            return text ? text.replace(/\n/g, '<br>') : '';
        }
    });
    </script>
@endsection
