<?php

namespace App\Http\Controllers\API;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Traits\HelpsResponse;

class CategoryController extends Controller
{
    use HelpsResponse;

    private $category;

    function __construct(CategoryRepository $category){
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->category->all());
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
                'name'=>'bail|required|unique:categories,name',
                'description'=>'nullable'
            ]);
            if($v->fails()){
                return $this->validationErrorResponse($v);
            }
            if($category = $this->category->create($request->all())){
                return $this->successResponse('Category created successfully',$category,'category',201);
            }
            return $this->errorResponse('Unable to create category, please try again');
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        try{
            $v = validator($request->all(),[
                'name'=>'bail|required',
                'description'=>'nullable'
            ]);
            if($v->fails()){
                return $this->validationErrorResponse($v);
            }
            if($this->category->valueExists('name',$request->name,$category->id)){
                return $this->errorResponse(['error'=>'category name already exists']);
            }
            if($category->update($request->all())){
                return $this->successResponse('Category updated successfully',$category->fresh(),'category',201);
            }
            return $this->errorResponse('Unable to update category, please try again');
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try{
            if($relations = $this->category->isRelatedTo($category,['listings'])){
                return $this->errorResponse("The category is being used by: [{$relations}]. Dessociate the category from them to delete");
            }
            if($category->delete()){
                return $this->SuccessResponse('Category deleted successfully');
            }else{
                return $this->errorResponse('Unable to delete category, please try again');
            }
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }
}
