<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Traits\HelpsResponse;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    use HelpsResponse;

    private $category;

    function __construct(CategoryRepository $category){
        $this->middleware('auth');
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories',['categories'=>$this->category->paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-category');
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
            $this->category->create($request->all());
            return $this->successResponse('Category created successfully');
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
    public function showDelete(Category $category)
    {
        return view('delete-category',['category'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('edit-category',['category'=>$category]);
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
                return $this->successMessage('Category updated successfully',route('categories'));
            }
            return $this->errorResponse(['error'=>'Unable to update category, please try again']);
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
                return $this->errorResponse(['error'=>"The category is being used by: [{$relations}]. Dessociate the category from them to delete"]);
            }
            if($category->delete()){
                return $this->SuccessMessage('Category deleted successfully',route('categories'));
            }else{
                return $this->errorResponse(['error'=>'Unable to delete category, please try again']);
            }
        }catch(\Exception $e){
            return $this->exceptionResponse($e);
        }
    }
}
