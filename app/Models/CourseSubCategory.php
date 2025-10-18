<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSubCategory extends Model {
    protected $fillable = ['title','description','thumbnail','category_id','company_id','created_by'];

    public function category() {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    public function courses() {
        return $this->hasMany(Course::class, 'sub_category_id');
    }
}
