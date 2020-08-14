<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComments extends Model
{
    //
    protected $table = 'blog_comments';
    public function blog(){
        return $this->belongsTo(Blogs::class,'blog_id' );
    }
}
