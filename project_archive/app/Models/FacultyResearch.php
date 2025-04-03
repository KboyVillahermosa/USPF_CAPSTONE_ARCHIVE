<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacultyResearch extends Model
{
    use HasFactory;

    protected $table = 'faculty_research';

    protected $fillable = [
        'project_name',
        'members',
        'department',
        'abstract',
        'banner_image',
        'file',
        'approved',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}