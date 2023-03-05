<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['receiver_id', 'message', 'read'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function conversationsWithUser(int $id)
    {
        return $this->where(function ($query) use ($id) {
            $query->where('sender_id', auth()->user()->id);
            $query->where('receiver_id', $id);
        })
            ->orWhere(function ($query) use ($id) {
                $query->where('sender_id', $id);
                $query->where('receiver_id', auth()->user()->id);
            })
            ->with(['sender', 'receiver'])
            ->get();
    }

    public function markMessagesAsRead(int $senderId)
    {
        return $this->where('sender_id', $senderId)
            ->where('read', false)
            ->where('receiver_id', auth()->user()->id)
            ->update(['read' => true]);
    }
}
