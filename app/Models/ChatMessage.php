<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';
    protected $primaryKey = 'id_message';
    public $timestamps = true;

    protected $fillable = [
        'id_conversation',
        'sender_type',
        'message',
        'is_read'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Accessor untuk created_at dalam waktu lokal
    public function getCreatedAtLocalAttribute()
    {
        return $this->created_at->timezone('Asia/Jakarta');
    }

    // Accessor untuk updated_at dalam waktu lokal
    public function getUpdatedAtLocalAttribute()
    {
        return $this->updated_at->timezone('Asia/Jakarta');
    }

    // Format waktu untuk tampilan chat
    public function getTimeDisplayAttribute()
    {
        return $this->created_at->timezone('Asia/Jakarta')->format('H:i');
    }

    // Format tanggal lengkap
    public function getDateDisplayAttribute()
    {
        $now = Carbon::now('Asia/Jakarta');
        $messageDate = $this->created_at->timezone('Asia/Jakarta');
        
        if ($messageDate->isToday()) {
            return 'Hari ini ' . $messageDate->format('H:i');
        } elseif ($messageDate->isYesterday()) {
            return 'Kemarin ' . $messageDate->format('H:i');
        } else {
            return $messageDate->format('d M Y H:i');
        }
    }

    public function conversation()
    {
        return $this->belongsTo(ChatConversation::class, 'id_conversation', 'id_conversation');
    }
}