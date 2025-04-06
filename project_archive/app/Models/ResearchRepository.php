<?php
namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResearchRepository extends Model {
    use CrudTrait, HasFactory;

    protected $fillable = ['user_id', 'project_name', 'members', 'department', 'curriculum', 'abstract', 'banner_image', 'file', 'approved'];

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
