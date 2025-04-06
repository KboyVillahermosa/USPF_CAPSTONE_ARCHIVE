<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Research extends Model
{
    protected $fillable = [
        'title',
        'publication_date',
        'department',
        'curriculum',
        'pdf_path',
        'authors',
        'abstract'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'authors' => 'array'
    ];

    public function getApaFormat()
    {
        $authors = implode(', ', $this->authors ?? []);
        return sprintf(
            "%s (%s). %s. %s Department, %s.",
            $authors,
            $this->publication_date->format('Y'),
            $this->title,
            $this->department,
            $this->curriculum
        );
    }

    public function getIeeeFormat()
    {
        $authors = implode(', ', $this->authors ?? []);
        return sprintf(
            '%s, "%s," %s Department, %s, %s.',
            $authors,
            $this->title,
            $this->department,
            $this->curriculum,
            $this->publication_date->format('Y')
        );
    }
}