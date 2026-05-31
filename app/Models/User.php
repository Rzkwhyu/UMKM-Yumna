<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'address',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * URL foto profil untuk tampilan.
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->avatar) {
                return asset($this->avatar);
            }

            return 'https://i.pravatar.cc/200?u=' . $this->id;
        });
    }

    /**
     * Username dengan prefix @ untuk tampilan.
     */
    protected function displayUsername(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->username) {
                return str_starts_with($this->username, '@')
                    ? $this->username
                    : '@' . $this->username;
            }

            $slug = Str::slug(Str::before($this->email, '@'), '');

            return '@' . ($slug ?: 'user' . $this->id);
        });
    }
}
