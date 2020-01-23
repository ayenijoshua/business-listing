@extends('layouts.app')

@section('listings-active')
    active
@endsection

@section('title')
    Delete listing
@endsection

@section('content')


    <div class="card">
        <div class="card-header">Delete Listing</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{route('delete-listing',$listing->id)}}" method="post">
                @csrf
                <p>Are you sure you want to delete this listing?</p>
                <button type="submit" class="btn btn-danger">Yes</button>
                <a class="btn btn-primary pull-right" href="{{route('listings')}}">No</a>
            </form>
        </div>

    </div>

@endsection