@extends('layouts.app')

@section('home-active')
    active
@endsection

@section('title')
    Dashboard
@endsection

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> --}}
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                                <div class="card-header">Listings</div>
                                <div class="card-body">
                                    <h5 class="card-title">Total Listings</h5>
                                    <h1 class="card-text">{{$listings_count}}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                                <div class="card-header">Categories</div>
                                <div class="card-body">
                                    <h5 class="card-title">Total Categories</h5>
                                    <h1 class="card-text">{{$categories_count}}</h1>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            {{-- </div>
        </div>
    </div>
</div> --}}
@endsection
