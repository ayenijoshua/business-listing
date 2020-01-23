@extends('layouts.app')

@section('create-category-active')
    active
@endsection

@section('title')
    Create category
@endsection

@section('content')

    

    <div class="card">
        <div class="card-header">Create Category</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

                <form method="POST" action="{{route('store-category')}}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Category name</label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="category name">
                        @error('name')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Category description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Category description"></textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <button type="submit" class="form-control btn btn-primary">Submit</button>
                    </div>
                </form>
        </div>
    </div>
           
@endsection
