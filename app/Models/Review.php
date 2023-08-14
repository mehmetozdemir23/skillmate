<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['mission_id', 'reviewer_id', 'comment', 'rating'];

    public function reviewer():BelongsTo{
        return $this->belongsTo(User::class,'reviewer_id');
    }
}
