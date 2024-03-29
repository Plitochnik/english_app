<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendsInvitation extends Model
{
    use HasFactory;

    protected $table = 'friends_invitation';

    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id')->select('id', 'name', 'profile_photo_path');
    }
}
