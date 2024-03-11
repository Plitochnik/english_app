<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isFriend()
    {
        return $this->hasOne(Friends::class, 'friend_id', 'id')
            ->where('user_id', auth()->user()->id);
    }

    public function isInvited()
    {
        return $this->hasOne(FriendsInvitation::class, 'receiver_user_id', 'id')
            ->where('sender_user_id', auth()->user()->id);
    }

    public function theySentInvite()
    {
        return $this->hasOne(FriendsInvitation::class, 'sender_user_id', 'id')
            ->where('receiver_user_id', auth()->user()->id);
    }
}
