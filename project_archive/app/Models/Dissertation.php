<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dissertation extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'type',
        'abstract',
        'department',
        'year',
        'file_path',
        'keywords',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}