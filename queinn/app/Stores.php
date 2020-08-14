<?php

namespace App\Admin;

use App\Coupons;
use App\StoreGallery;
use App\StoreReviews;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    //
    public function coupon(){
        return $this->hasMany(Coupons::class, 'store_id')->where('status', 1)->orderByDesc('created_at');
    }

    public function couponActiveSearch(){
        return $this->hasMany(Coupons::class, 'store_id')->where('status', 1)->where('valid_till', '>=', Carbon::now());
    }

    public function storeReview(){
        return $this->hasMany(StoreReviews::class, 'store_id')->where('status', 2);
    }

    public function storeGallery(){
        return $this->hasMany(StoreGallery::class, 'store_id');
    }
}
