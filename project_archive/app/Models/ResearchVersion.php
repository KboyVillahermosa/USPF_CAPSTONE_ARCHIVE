<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'research_id',
        'version_number',
        'file_path',
        'changes_made'
    ];

    /**
     * Get the research that owns this version
     */
    public function research()
    {
        return $this->belongsTo(Research::class);
    }

    /**
     * Get the formatted created date
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('F d, Y');
    }

    /**
     * Get the file name from the file path
     */
    public function getFileNameAttribute()
    {
        return basename($this->file_path);
    }
}