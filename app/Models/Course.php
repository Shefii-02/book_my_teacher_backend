<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    protected $fillable = ['title','description','thumbnail','category_id','sub_category_id','duration','duration_type','started_at','ended_at','company_id','created_by'];

    public function category() { return $this->belongsTo(CourseCategory::class); }
    public function subCategory() { return $this->belongsTo(CourseSubCategory::class); }
    public function classes() { return $this->hasMany(CourseClass::class, 'course_id'); }
}
