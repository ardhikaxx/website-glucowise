<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    // Get list semua dokter
    public function getDokters()
    {
        try {
            $dokters = Admin::where('hak_akses', 'Dokter')
                ->select('id_admin', 'nama_lengkap', 'jenis_kelamin', 'nomor_telepon')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $dokters
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dokter'
            ], 500);
        }
    }

    // Buat atau dapatkan conversation
    public function getOrCreateConversation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|exists:pengguna,nik',
            'id_admin' => 'required|exists:admin,id_admin'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $conversation = ChatConversation::firstOrCreate(
                [
                    'nik' => $request->nik,
                    'id_admin' => $request->id_admin
                ],
                [
                    'status' => 'active'
                ]
            );

            return response()->json([
                'success' => true,
                'data' => $conversation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat conversation'
            ], 500);
        }
    }

    // Kirim pesan
    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_conversation' => 'required|exists:chat_conversations,id_conversation',
            'sender_type' => 'required|in:pengguna,dokter',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $chatMessage = ChatMessage::create([
                'id_conversation' => $request->id_conversation,
                'sender_type' => $request->sender_type,
                'message' => $request->message
            ]);

            // Update last_message_at di conversation
            $conversation = ChatConversation::find($request->id_conversation);
            $conversation->update(['last_message_at' => now()]);

            return response()->json([
                'success' => true,
                'data' => $chatMessage
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan'
            ], 500);
        }
    }

    // Get messages dari conversation
    public function getMessages($id_conversation)
    {
        try {
            $messages = ChatMessage::where('id_conversation', $id_conversation)
                ->orderBy('created_at', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $messages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil pesan'
            ], 500);
        }
    }

    // Get list conversations untuk pengguna
    public function getUserConversations($nik)
    {
        try {
            $conversations = ChatConversation::with(['dokter:id_admin,nama_lengkap', 'lastMessage'])
                ->where('nik', $nik)
                ->orderBy('last_message_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $conversations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil conversations'
            ], 500);
        }
    }

    // Tandai pesan sebagai dibaca
    public function markAsRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_message' => 'required|exists:chat_messages,id_message'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $message = ChatMessage::find($request->id_message);
            $message->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai pesan'
            ], 500);
        }
    }
}