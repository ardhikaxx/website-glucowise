<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    use HasFactory;

    protected $table = 'chat_conversations';
    protected $primaryKey = 'id_conversation';
    public $timestamps = true;

    protected $fillable = [
        'nik',
        'id_admin',
        'status',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'nik', 'nik');
    }

    public function dokter()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'id_conversation', 'id_conversation');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'id_conversation', 'id_conversation')->latest();
    }

    public function unreadMessagesCount()
    {
        return $this->messages()->where('is_read', false)->where('sender_type', 'pengguna')->count();
    }
}