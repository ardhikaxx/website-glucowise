@extends('layouts.main')

@section('title', 'Chat dengan ' . $conversation->pengguna->nama_lengkap)

@section('content')
    <div class="container-fluid">
        <!-- Header Chat -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title" style="font-weight: bold; font-size: 36px; color: #34B3A0;">
                            <i class="ti ti-messages me-3" style="color: #34B3A0;"></i>
                            Chat dengan {{ $conversation->pengguna->nama_lengkap }}
                        </h1>
                    </div>
                    <div>
                        <a href="{{ route('chat.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Chat -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Info Pengguna -->
                        <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                            <i class="ti ti-user-circle fs-8 text-primary me-3"></i>
                            <div>
                                <h5 class="mb-1">{{ $conversation->pengguna->nama_lengkap }}</h5>
                                <small class="text-muted">NIK: {{ $conversation->pengguna->nik }}</small>
                            </div>
                            <div class="ms-auto">
                                <small class="text-muted" id="current-time">
                                    <i class="ti ti-clock me-1"></i>
                                    <span id="local-time"></span>
                                </small>
                            </div>
                        </div>

                        <!-- Messages Area -->
                        <div id="messages-container" class="messages-container mb-3">
                            @if ($messages->count() > 0)
                                @php
                                    $currentDate = null;
                                @endphp
                                @foreach ($messages as $message)
                                    @php
                                        $messageDate = $message->created_at->timezone('Asia/Jakarta')->format('Y-m-d');
                                    @endphp

                                    @if ($messageDate != $currentDate)
                                        @php
                                            $currentDate = $messageDate;
                                            $displayDate = $message->created_at->timezone('Asia/Jakarta');
                                            if ($displayDate->isToday()) {
                                                $dateLabel = 'Hari ini';
                                            } elseif ($displayDate->isYesterday()) {
                                                $dateLabel = 'Kemarin';
                                            } else {
                                                $dateLabel = $displayDate->translatedFormat('j F Y');
                                            }
                                        @endphp
                                        <div class="date-divider text-center my-3">
                                            <span class="badge bg-secondary">{{ $dateLabel }}</span>
                                        </div>
                                    @endif
                                        
                                    <div class="message {{ $message->sender_type == 'dokter' ? 'message-sent' : 'message-received' }}"
                                        data-message-id="{{ $message->id_message }}"
                                        data-created-at="{{ $message->created_at }}">
                                        <div class="message-content">
                                            {{ $message->message }}
                                        </div>
                                        <div class="message-time">
                                            {{ $message->created_at->timezone('Asia/Jakarta')->format('H:i') }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="ti ti-messages-off fs-1 mb-2"></i>
                                    <p>Belum ada pesan</p>
                                    <small>Mulai percakapan dengan mengirim pesan</small>
                                </div>
                            @endif
                        </div>

                        <!-- Input Message -->
                        <div class="message-input-container">
                            <form id="message-form" class="d-flex">
                                @csrf
                                <input type="text" id="message-input" class="form-control me-2"
                                    placeholder="Ketik pesan..." maxlength="1000" required>
                                <button type="submit" class="btn btn-primary" id="send-button">
                                    <i class="ti ti-send"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .messages-container {
            height: 500px;
            overflow-y: auto;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            animation: fadeIn 0.3s ease-in;
        }

        .message-sent {
            align-items: flex-end;
        }

        .message-received {
            align-items: flex-start;
        }

        .message-content {
            padding: 12px 16px;
            border-radius: 18px;
            max-width: 70%;
            word-wrap: break-word;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .message-sent .message-content {
            background: linear-gradient(135deg, #34B3A0 0%, #2a9d8a 100%);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message-received .message-content {
            background-color: white;
            border: 1px solid #e1e5e9;
            color: #333;
            border-bottom-left-radius: 5px;
        }

        .message-time {
            font-size: 0.7rem;
            color: #6c757d;
            margin-top: 5px;
            padding: 0 5px;
        }

        .message-input-container {
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }

        .date-divider {
            position: relative;
        }

        .date-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
            z-index: 1;
        }

        .date-divider .badge {
            position: relative;
            z-index: 2;
            background-color: #6c757d;
            font-weight: normal;
            padding: 5px 10px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .typing-indicator {
            display: none;
            padding: 10px 15px;
            color: #6c757d;
            font-style: italic;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messages-container');
            const messageForm = document.getElementById('message-form');
            const messageInput = document.getElementById('message-input');
            const sendButton = document.getElementById('send-button');
            const localTimeElement = document.getElementById('local-time');

            let lastMessageId = {{ $messages->last() ? $messages->last()->id_message : 0 }};
            let isPolling = false;

            // Update waktu lokal
            function updateLocalTime() {
                const now = new Date();
                const options = {
                    timeZone: 'Asia/Jakarta',
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };
                localTimeElement.textContent = now.toLocaleTimeString('id-ID', options);
            }

            // Update waktu setiap detik
            updateLocalTime();
            setInterval(updateLocalTime, 1000);

            // Scroll to bottom
            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Format waktu dari UTC ke WIB
            function formatTimeToWIB(utcDateString) {
                const date = new Date(utcDateString);
                return date.toLocaleTimeString('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
            }

            // Format tanggal untuk divider
            function formatDateForDivider(utcDateString) {
                const date = new Date(utcDateString);
                const today = new Date();
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);

                const options = {
                    timeZone: 'Asia/Jakarta'
                };
                const messageDate = new Date(date.toLocaleString('en-US', options));
                const todayDate = new Date(today.toLocaleString('en-US', options));
                const yesterdayDate = new Date(yesterday.toLocaleString('en-US', options));

                if (messageDate.toDateString() === todayDate.toDateString()) {
                    return 'Hari ini';
                } else if (messageDate.toDateString() === yesterdayDate.toDateString()) {
                    return 'Kemarin';
                } else {
                    return messageDate.toLocaleDateString('id-ID', {
                        timeZone: 'Asia/Jakarta',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                }
            }

            // Add message to UI
            function addMessage(message, isSent) {
                // Cek apakah message sudah ada
                const existingMessage = document.querySelector(`[data-message-id="${message.id_message}"]`);
                if (existingMessage) {
                    return; // Skip jika message sudah ada
                }

                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isSent ? 'message-sent' : 'message-received'}`;
                messageDiv.setAttribute('data-message-id', message.id_message);
                messageDiv.setAttribute('data-created-at', message.created_at);

                const timeWIB = formatTimeToWIB(message.created_at);

                messageDiv.innerHTML = `
                    <div class="message-content">${message.message}</div>
                    <div class="message-time">${timeWIB}</div>
                `;

                messagesContainer.appendChild(messageDiv);

                // Update last message ID
                if (message.id_message > lastMessageId) {
                    lastMessageId = message.id_message;
                }

                scrollToBottom();
            }

            // Load messages dari database
            function loadMessages() {
                if (isPolling) return;

                isPolling = true;

                fetch(`{{ route('chat.messages', $conversation->id_conversation) }}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(messages => {
                        // Clear existing messages first (kecuali yang dari form)
                        const existingMessages = Array.from(messagesContainer.querySelectorAll('.message'));
                        const existingMessageIds = existingMessages.map(msg =>
                            parseInt(msg.getAttribute('data-message-id'))
                        );

                        // Add only new messages
                        messages.forEach(message => {
                            if (!existingMessageIds.includes(message.id_message)) {
                                addMessage(message, message.sender_type === 'dokter');
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error loading messages:', error);
                    })
                    .finally(() => {
                        isPolling = false;
                    });
            }

            // Load only new messages (optimized)
            function loadNewMessages() {
                if (isPolling) return;

                isPolling = true;

                fetch(`/chat/{{ $conversation->id_conversation }}/new-messages?last_message_id=${lastMessageId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(messages => {
                        messages.forEach(message => {
                            addMessage(message, message.sender_type === 'dokter');
                        });
                    })
                    .catch(error => {
                        console.error('Error loading new messages:', error);
                        // Fallback ke load semua messages jika endpoint baru tidak ada
                        loadMessages();
                    })
                    .finally(() => {
                        isPolling = false;
                    });
            }

            // Send message
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const messageText = messageInput.value.trim();
                if (!messageText) return;

                // Disable form sementara
                sendButton.disabled = true;
                const originalText = sendButton.innerHTML;
                sendButton.innerHTML = '<i class="ti ti-clock"></i>';

                fetch('{{ route('chat.send', $conversation->id_conversation) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            message: messageText
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Tambahkan pesan ke UI
                            addMessage(data.message, true);
                            messageInput.value = '';
                        } else {
                            alert('Gagal mengirim pesan: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                        alert('Gagal mengirim pesan. Silakan coba lagi.');
                    })
                    .finally(() => {
                        sendButton.disabled = false;
                        sendButton.innerHTML = originalText;
                        messageInput.focus();
                    });
            });

            // Auto scroll ke bottom saat pertama kali load
            scrollToBottom();

            // Poll untuk pesan baru setiap 2 detik
            setInterval(loadNewMessages, 2000);

            // Juga load messages saat halaman focus
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    loadNewMessages();
                }
            });

            // Focus input message
            messageInput.focus();

            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    messageForm.dispatchEvent(new Event('submit'));
                }
            });
        });
    </script>
@endsection
