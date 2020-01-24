<?php

namespace App\Http\Controllers\API;

use App\Listing;
use Illuminate\Http\Request;
use App\Traits\HelpsResponse;
use App\Http\Controllers\Controller;
use App\Repositories\ListingRepository;
use App\Repositories\CategoryRepository;

class ListingController extends Controller
{
    use HelpsResponse;

    private $listing,$category;

    function __construct(ListingRepository $listing, CategoryRepository $category){
        
        $this->listing = $listing;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \response()->json($this->listing->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $v = validator($request->all(),[
                'name'=>'bail|required|unique:listings,name',
                'email'=>'bail|required|email',
                'description'=>'required',
                'categories'=>'bail|required|array',
                'categories .*'=>'exists:categories,id',
                'url'=>'nullable',
                'address'=>'bail|required',
                'phones'=>'nullable'
            ]);
            if($v->fails()){
                return $this->validationErrorResponse($v);
            }
            if($listing = $this->listing->createListing($request)){
                return $this->successResponse('Busines listing created successfully',$listing,'listing',201);
            }
            return $this->errorResponse('Unable to create business, please try again');
        }catch(\Exection $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        return response()->json($listing);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Listing $listing)
    {
        try{
            $v = validator($request->all(),[
                'name'=>'required',
                'email'=>'bail|required|email',
                'description'=>'required',
                'categories'=>'bail|required|array',
                'categories .*'=>'exists:categories,id',
                'url'=>'nullable',
                'address'=>'bail|required',
                'phones'=>'nullable'
            ]);
            if($v->fails()){
                return $this->validationErrorResponse($v);
            }
            if($this->listing->valueExists('name',$request->name,$listing->id)){
                return $this->errorResponse('Name of business already exists');
            }
            if($this->listing->valueExists('email',$request->email,$listing->id)){
                return $this->errorResponse('Email of business already exists');
            }
            if($this->listing->updateListing($listing,$request)){
                return $this->successResponse('Busines listing updated successfully',$listing->fresh(),'listing',201);
            }
            return $this->errorResponse('Unable to update business, please try again');
        }catch(\Exection $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        try{
            $this->listing->detachRelations($listing,['categories']);
            if($listing->delete()){
                return $this->SuccessResponse('listing deleted successfully');
            }
            return $this->errorResponse('Unable to delete listng, please try again');
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * deactivate listing
     */
    public function deactivate(Listing $listing){
        try{
            if($listing->update(['is_deactived'=>true])){
                return $this->successResponse('Listing deactivated successfully',$listing->fresh(),'listing',201);
            }
           return $this->errorResponse('Unable to deactivate listing, pplease try again');
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * ativate a listing
     */
    public function activate(Listing $listing){
        try{
            if($listing->update(['is_deactived'=>false])){
                return $this->successResponse('Listing activated successfully',$listing->fresh(),'listing',201);
            }
           return $this->errorResponse('Unable to activate listing, pplease try again');
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * delete listing image
     */
    public function deleteImage(ListingImage $image){
        try{
            $this->listing->processImageDelete($image);
            return $this->successResponse('Image deleted succesfully');
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * add image to listing
     */
    public function addImages(Request $request, Listing $listing){
        try{
            $v = validator($request->all(),[
                'images'=>'bail|required|array',
                'images .*'=> 'image|mimes:png,jpg,gif,jpeg,svg|max:2048'
            ]);
            if($v->fails()){
                return $this->validationErrorResponse($v);
            }
            $this->listing->processImagesUpload($listing,$request);
            return $this->successResponse('Images uploaded succesfully',$listing->load('images'),'listing-images');
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * search listings
     */
    public function search(Request $request){
        try{
            if(!$request->name && !$request->description){
                return response()->json('You have not entered any search parameter');
            }
          $search =  Listing::where('name','LIKE','%'.$request->name.'%')->where('description','LIKE','%'.$request->description.'%')->get();
            if(count($search)<1){
                return response()->json('Sorry, we could not find any result for your search');
            }
            return response()->json($search);
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }
}
