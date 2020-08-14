<?php

namespace App;

use App\Admin\Stores;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    //
    protected $table = 'coupons';
    public function store(){
        return $this->belongsTo(Stores::class, 'store_id');
    }
}
