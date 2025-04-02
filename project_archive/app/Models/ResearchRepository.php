<?php
namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchRepository extends Model {
    use CrudTrait, HasFactory;

    protected $fillable = ['user_id', 'project_name', 'members', 'department', 'abstract', 'banner_image', 'file', 'approved'];

    // Define the relationship (Research belongs to a User)
   
    
}
