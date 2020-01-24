<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endguest

                        @auth
                            <li class="nav-item dropdown">
                                <a  class="dropdown-item" href="{{route('home')}}" role="button">
                                    Dashboard
                                </a>
                            </li>
                            
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                        @endauth
                            

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="card">
                <div class="card-header">Business Listings</div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>{{ session('success') }}</strong>
                    </div><br>
                    @endif
                </div>
                <div class="col-md-12 mb-3">
                    @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ session('error') }}</strong>
                    </div><br>
                    @endif
                </div>
                @error('error')
                    <div class=" col-md-12 mb-3 alert alert-danger text-center">{{$message}}</div>
                @enderror
            </div>

            <hr>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form method="POST" action="{{route('search-listings')}}">
                        @csrf
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                            <label class="sr-only" for="inlineFormInput">Name</label>
                            <input type="text"name="name" class="form-control mb-2" id="inlineFormInput" placeholder="Name">
                            </div>
                            <div class="col-auto">
                            <label class="sr-only" for="inlineFormInputGroup">Username</label>
                            <div class="input-group mb-2">
                                
                                <input name="description" type="text" class="form-control" id="inlineFormInputGroup" placeholder="Description">
                            </div>
                            </div>
                            
                            <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body">
                @forelse($listings as $listing)
                    <div class="row">
                    
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-body">
                                <h5 class="card-title">{{$listing->name}}</h5>
                                <p class="card-text">{{$listing->description}}</p>
                                <a href="{{route('show-listing',$listing->id)}}" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <hr>
                @empty
                        <div class="alert alert-danger">There are no business listings</div>
                @endforelse
                {{$listings->links()}}
                
            </div>


        </div>
        


       
    </body>
</html>
