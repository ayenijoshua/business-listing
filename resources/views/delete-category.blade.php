@extends('layouts.app')

@section('categories-active')
    active
@endsection

@section('title')
    Delete category
@endsection

@section('content')


    <div class="card">
        <div class="card-header">Delete Catgeory</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{route('delete-category',$category->id)}}" method="post">
                @csrf
                <p>Are you sure you want to delete this category?</p>
                <button type="submit" class="btn btn-danger">Yes</button>
                <a class="btn btn-primary pull-right" href="{{route('categories')}}">No</a>
            </form>
        </div>

    </div>

@endsection