<?php

namespace App;

use App\Admin\Stores;
use Illuminate\Database\Eloquent\Model;

class StoreGallery extends Model
{
    //
    protected $table = 'store_galleries';
    public function storeRelatedToGallery(){
        return $this->belongsTo(Stores::class);
    }
}
