<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'name', 'slug', 'parent_id', 'description',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function parent()
    {
        return $this->belongsTo(MediaFolder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MediaFolder::class, 'parent_id');
    }

    public function files()
    {
        return $this->hasMany(MediaFile::class, 'folder_id');
    }
}
