<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'avatar',
        'email',
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

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => $value ?? 'default-avatar.svg'
        );
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'skill_user');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function missions(): HasManyThrough
    {
        return $this->hasManyThrough(Mission::class, Service::class);
    }

    public function receivedMissions(): HasMany
    {
        return $this->hasMany(Mission::class, 'receiver_id');
    }

    public function sentServiceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'sender_id');
    }

    public function receivedServiceRequests(): HasManyThrough
    {
        return $this->hasManyThrough(ServiceRequest::class, Service::class, 'user_id', 'service_id', 'id', 'id');
    }

}