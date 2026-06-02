<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'visit_count', 'first_visit', 'last_visit'
    ];

    protected $casts = [
        'first_visit' => 'datetime',
        'last_visit' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
