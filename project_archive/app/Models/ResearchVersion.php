<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResearchVersion extends Model
{
    protected $fillable = [
        'research_id',
        'version_number',
        'change_description',
        'file_path'
    ];

    public function research()
    {
        return $this->belongsTo(Research::class);
    }
}