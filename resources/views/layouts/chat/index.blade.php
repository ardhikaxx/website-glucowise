@extends('layouts.main')

@section('title', 'Chat Konsultasi')

@section('content')
    <div class="container-fluid">
        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">
                    <i class="ti ti-messages me-3" style="color: #34B3A0;"></i>Chat Konsultasi
                </h1>
            </div>
        </div>

        <!-- Card List Conversations -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Percakapan</h5>

                        @if ($conversations->count() > 0)
                            <div class="list-group">
                                @foreach ($conversations as $conversation)
                                    <a href="{{ route('chat.show', $conversation->id_conversation) }}"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-3">
                                                <i class="ti ti-user-circle fs-8 text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">{{ $conversation->pengguna->nama_lengkap }}</h6>
                                                <p class="mb-1 text-muted small">
                                                    @if ($conversation->lastMessage)
                                                        {{ Str::limit($conversation->lastMessage->message, 50) }}
                                                    @else
                                                        Belum ada pesan
                                                    @endif
                                                </p>
                                                <small class="text-muted">
                                                    {{ $conversation->last_message_at ? $conversation->last_message_at->diffForHumans() : 'Belum ada pesan' }}
                                                </small>
                                            </div>
                                        </div>
                                        @if ($conversation->unreadMessagesCount() > 0)
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $conversation->unreadMessagesCount() }}
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="ti ti-messages-off fs-1 text-muted mb-3"></i>
                                <p class="text-muted">Belum ada percakapan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .list-group-item {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
            border-color: #34B3A0;
        }

        .avatar {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 50%;
        }
    </style>

    <script>
        // Auto refresh unread count
        function updateUnreadCount() {
            fetch('{{ route('chat.unread.count') }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('unread-chat-count');
                    if (data.unread_count > 0) {
                        badge.textContent = data.unread_count;
                        badge.style.display = 'inline';
                    } else {
                        badge.style.display = 'none';
                    }
                });
        }

        // Update setiap 30 detik
        setInterval(updateUnreadCount, 30000);
        updateUnreadCount(); // Initial call
    </script>
@endsection
