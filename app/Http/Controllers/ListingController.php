<?php

namespace App\Http\Controllers;

use App\Listing;
use Illuminate\Http\Request;
use App\Traits\HelpsResponse;
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
        return view('listings',['listings'=>$this->listing->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-listing',['categories'=>$this->category->all()]);
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
            if($this->listing->createListing($request)){
                return $this->successMessage('Busines listing created successfully');
            }
            return $this->errorResponse(['error'=>'Unable to create business, please try again']);
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
        return view('delete-listing',['listing'=>$listing]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function edit(Listing $listing)
    {
    return view('edit-listing',['categories'=>$this->category->all(),'listing'=>$listing]);
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
                return $this->errorResponse(['error','Name of business already exists']);
            }
            if($this->listing->valueExists('email',$request->email,$listing->id)){
                return $this->errorResponse(['error','Email of business already exists']);
            }
            if($this->listing->updateListing($listing,$request)){
                return $this->successMessage('Busines listing updated successfully');
            }
            return $this->errorResponse(['error'=>'Unable to update business, please try again']);
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
                return $this->SuccessMessage('listing deleted successfully',route('listings'));
            }
            return $this->errorResponse(['error'=>'Unable to delete listng, please try again']);
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * confirm list deactivation
     */
    public function showDeactivate(Listing $listing){
        return view('deactivate-listing',['listing'=>$listing]);
    }

    /**
     * deactivate listing
     */
    public function deactivate(Listing $listing){
        try{
            if($listing->update(['is_deactived'=>true])){
                return $this->successMessage('Listing deactivated successfully',route('listings'));
            }
           return $this->errorResponse(['error'=>'Unable to deactivate listing, pplease try again']);
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

     /**
     * confirm list activation
     */
    public function showActivate(Listing $listing){
        return view('activate-listing',['listing'=>$listing]);
    }

    /**
     * ativate a listing
     */
    public function activate(Listing $listing){
        try{
            if($listing->update(['is_deactived'=>false])){
                return $this->successMessage('Listing activated successfully',route('listings'));
            }
           return $this->errorResponse(['error'=>'Unable to activate listing, pplease try again']);
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }
}
