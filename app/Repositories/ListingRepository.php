<?php
namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;
use App\Listing;

class ListingRepository extends Repository{
    function __construct(Listing $listing){
        parent::__construct($listing);
    }


    /**
     * create listing
     */
    public function createListing($request){
        DB::transaction(function() use ($request){
            $listing = $this->create($request->except('images','categories'));
            $listing->categories()->attach($request->categories);
            /**
             * un-comment below to add upload image functionalty
             */
            //$this->processImagesUpload($listing,$request);
            $this->returnVal = $listing;
        });
        return $this->returnVal;
    }

    /**
     * upload listing images/logos
     */
    public function processImagesUpload($listing,$request){
        //DB::transaction(function() use ($request){
            foreach ($request->files->get('images') as $key => $value) {
                //$image_name = time()."_".$request->file('images')[$key]->getClientOriginalName();
                $image_path = $request->file('images')[$key]->store('listing-images','public');
                if(!$image_path){
                    throw new \Exception("Unable to upload image");
                }
                $image = new \App\Models\ListingImage(['path'=>$image_path]);
                $listing->images()->save($image);
            }
            App::make('files')->link(\storage_path('app/public'), public_path('storage'));
    }

    public function updateListing($listing,$request){
        DB::transaction(function() use ($request,$listing){
            $update = $listing->update($request->except('categories'));
            $listing->categories()->sync($request->categories);
            /**
             * un-comment below to add upload image functionalty
             */
            //$this->processImagesUpload($listing,$request);
            $this->returnVal = $update;
        });
        return $this->returnVal;
    }
}


