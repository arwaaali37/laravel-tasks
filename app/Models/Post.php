<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
class Post extends Model
{   
    use Sluggable;
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    protected $fillable = ['title', 'description', 'creator_id', 'image','slug'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function getHumanReadableDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }
}
