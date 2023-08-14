<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'service_id', 'notes'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function receiver(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Service::class, 'id', 'id', 'service_id', 'user_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
