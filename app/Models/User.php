<?php

namespace App\Models;

use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Reservation;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

#[UsePolicy(UserPolicy::class)]
class User extends Authenticatable implements MustVerifyEmail, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    const TABLE = "users";
    protected $table = self::TABLE;
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin == true;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(related: Reservation::class, foreignKey: "user_id", localKey: "id");
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(related: Review::class, foreignKey: 'user_id', localKey: 'id');
    }
}
