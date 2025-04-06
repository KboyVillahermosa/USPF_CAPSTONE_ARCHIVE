<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadLog extends Model
{
    protected $fillable = [
        'research_id',
        'user_id',
        'purposes',
        'ip_address'
    ];

    protected $casts = [
        'purposes' => 'array'
    ];

    public function research()
    {
        return $this->belongsTo(ResearchRepository::class, 'research_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}