<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
   public $fillable = ['name','parent'];

    /**
     * Get the index name for the model.
     *
     * @return string
    */
    public function childs() {
        return $this->hasMany('App\Categories','parent','id') ;
    }
}
