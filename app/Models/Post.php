<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id', 'category_id');
    }

    public function comments()
{
    return $this->hasMany(Comment::class, 'post_id', 'id')->whereNull('parent_id')->with(['user', 'replies']);
}
}
