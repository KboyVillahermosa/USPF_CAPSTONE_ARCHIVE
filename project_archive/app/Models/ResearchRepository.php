<?php
namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResearchRepository extends Model {
    use CrudTrait, HasFactory;

    protected $table = 'research_repositories'; // Make sure this matches your database table

    protected $fillable = [
        'project_name',
        'members',
        'department',
        'curriculum',
        'abstract',
        'file',
        'banner_image',
        'user_id',
        'approved',
        'rejected',
        'rejection_reason',
        'view_count',
        'download_count'
    ];

    // Default values for new records
    protected $attributes = [
        'view_count' => 0,
        'download_count' => 0,
        'approved' => false,
        'rejected' => false
    ];

    protected $casts = [
        'rejected' => 'boolean',
    ];

    public function setDepartmentAttribute($value)
    {
        // Log the value being set
        \Log::info('Setting department attribute: ' . $value);
        
        // Make sure we never set null values
        $this->attributes['department'] = $value ? $value : 'Not specified';
    }

    public function getDepartmentAttribute($value)
    {
        // Make sure we never return null values
        return $value ? $value : 'Not specified';
    }

    public function getRelatedStudies()
    {
        // Get keywords from the current project's title
        $keywords = collect(explode(' ', $this->project_name))
            ->filter(function($word) {
                // Filter out common words and short terms
                $commonWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of'];
                return !in_array(strtolower($word), $commonWords) && strlen($word) > 3;
            });

        // Build query for related studies
        $query = static::where('id', '!=', $this->id)
            ->where('approved', true)
            ->where(function($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('project_name', 'like', '%' . $keyword . '%')
                      ->orWhere('abstract', 'like', '%' . $keyword . '%');
                }
            })
            ->limit(4);

        return $query->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
