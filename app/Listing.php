<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $guarded = [];

    /**
     * a business listing belongso many categories
     */
    public function categories(){
        return $this->belongsToMany(Category::class,'categories_listings');
    }

    /**
     * listing has many images
     */
    public function images(){
        return $this->hasMany(ListingImage::class);
    }
}
