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
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * @mixin EloquentBuilder
 * @mixin QueryBuilder
 */
class Game extends Authenticatable
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'is_online',
        'is_private',
        'total_questions',
        'test_from',
        'test_to',
        'language_level',
        'winner_user_id',
        'players_count',
        'key',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
