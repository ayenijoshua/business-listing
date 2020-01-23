<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    /**
     * category belongs to many listings
     */
    public function listings(){
        return $this->belongsToMany(Listing::class,'categories_listings');
    }
}
