<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogTags extends Model
{
    //
    protected $table = 'blog_tags';

    public function blogs()
    {
        return $this->belongsToMany(Blogs::class);
    }
}
