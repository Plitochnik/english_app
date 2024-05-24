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
class GameAnswers extends Authenticatable
{
    use HasFactory;

    protected $table = 'game_answers';

    protected $fillable = [
        'user_id',
        'game_id',
        'question_word_id',
        'answer_word_id',
        'correct_answer_word_id',
        'is_correct_answer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
