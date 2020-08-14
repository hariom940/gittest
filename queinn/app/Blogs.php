<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Blogs extends Model
{
    protected $table = 'blogs';
    //
    public function tags()
    {
        return $this->belongsToMany(BlogTags::class, 'blog_tags');
    }

    public function comments()
    {
        return $this->hasMany(BlogComments::class);
    }

}
