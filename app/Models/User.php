<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['name', 'email', 'password', 'is_admin', 'avatar'];
    protected $appends = ['avatar_url'];
    protected $hidden = ['password', 'remember_token'];
    public function getAvatarUrlAttribute(): string { return Media::url($this->avatar) ?: asset('sneat/assets/img/avatars/1.png'); }

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed', 'is_admin' => 'boolean'];
    }
}
