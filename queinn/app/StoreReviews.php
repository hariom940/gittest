<?php

namespace App;

use App\Admin\Stores;
use Illuminate\Database\Eloquent\Model;

class StoreReviews extends Model
{
    //
    protected $table = 'store_reviews';
    public function store(){
        return $this->belongsTo(Stores::class);
    }
}
