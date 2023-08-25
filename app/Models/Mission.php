<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'receiver_id','status'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
