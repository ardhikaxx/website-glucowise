<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $dokter = Auth::user();

        $conversations = ChatConversation::with(['pengguna', 'lastMessage'])
            ->where('id_admin', $dokter->id_admin)
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('layouts.chat.index', compact('conversations'));
    }

    public function showChat($id_conversation)
    {
        $conversation = ChatConversation::with(['pengguna'])
            ->where('id_conversation', $id_conversation)
            ->where('id_admin', Auth::user()->id_admin)
            ->firstOrFail();

        $messages = ChatMessage::where('id_conversation', $id_conversation)
            ->orderBy('created_at', 'asc')
            ->get();

        ChatMessage::where('id_conversation', $id_conversation)
            ->where('sender_type', 'pengguna')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('layouts.chat.page_chat', compact('conversation', 'messages'));
    }

    public function sendMessage(Request $request, $id_conversation)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $conversation = ChatConversation::where('id_conversation', $id_conversation)
            ->where('id_admin', Auth::user()->id_admin)
            ->firstOrFail();

        $chatMessage = ChatMessage::create([
            'id_conversation' => $id_conversation,
            'sender_type' => 'dokter',
            'message' => $request->message,
            'is_read' => true
        ]);

        $conversation->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $chatMessage
        ]);
    }

    public function getMessages($id_conversation)
    {
        $conversation = ChatConversation::where('id_conversation', $id_conversation)
            ->where('id_admin', Auth::user()->id_admin)
            ->firstOrFail();

        $messages = ChatMessage::where('id_conversation', $id_conversation)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function getUnreadCount()
    {
        $dokter = Auth::user();

        $unreadCount = ChatConversation::where('id_admin', $dokter->id_admin)
            ->withCount([
                'messages as unread_messages_count' => function ($query) {
                    $query->where('is_read', false)
                        ->where('sender_type', 'pengguna');
                }
            ])
            ->get()
            ->sum('unread_messages_count');

        return response()->json(['unread_count' => $unreadCount]);
    }

    public function getNewMessages($id_conversation, Request $request)
    {
        $conversation = ChatConversation::where('id_conversation', $id_conversation)
            ->where('id_admin', Auth::user()->id_admin)
            ->firstOrFail();

        $lastMessageId = $request->input('last_message_id', 0);

        $messages = ChatMessage::where('id_conversation', $id_conversation)
            ->where('id_message', '>', $lastMessageId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }
}