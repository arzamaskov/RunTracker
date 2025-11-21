<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Casts\UuidCast;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\UuidInterface;

/**
 * @property UuidInterface $id
 * @property string $email
 * @property string $password
 * @property-read Carbon|null $created_at
 * @property-read Carbon|null $updated_at
 */
class User extends Authenticatable
{
    public $incrementing = false;

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'identity.users';

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => UuidCast::class,
            'email_verified_at' => 'datetime',
        ];
    }
}
