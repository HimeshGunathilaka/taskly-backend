<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'priority',
        'status',
        'date',
    ];

    // Relationship with user: Each task belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
