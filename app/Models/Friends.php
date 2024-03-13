<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    use HasFactory;

    protected $table = 'friends';

    protected $fillable = [
        'user_id',
        'friend_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
