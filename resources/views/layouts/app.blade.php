<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <style>
        .invalid-feedback{
            display: block !important;
            margin: 0 !important;
        }
    </style>
</head>
<body>
    <div id="app">
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
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @auth
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
        @endauth

            <main class="py-4">
                <div class="container ">
                    <div class="row justify-content-center">
                        @auth
                            <div class="col-md-3">
                                <div class="list-group">
                                    <a href="/home" class="list-group-item list-group-item-action @yield('home-active')">
                                        dashboard
                                    </a>
                                    <a href="{{route('create-category')}}" class="list-group-item list-group-item-action @yield('create-category-active')">@if(Route::currentRouteName()=='edit-category') Edit Category @else Create Category @endif</a>
                                    <a href="{{route('categories')}}" class="list-group-item list-group-item-action @yield('categories-active')">Categories</a>
                                    <a href="{{route('create-listing')}}" class="list-group-item list-group-item-action @yield('create-listing-active')">@if(Route::currentRouteName()=='edit-listing')Edit Listing @else Create Listing @endif</a>
                                    <a href="{{route('listings')}}" class="list-group-item list-group-item-action @yield('listings-active')">Listings</a>
                                    <a href="{{route('listings')}}" class="list-group-item list-group-item-action @yield('logout-active')">Log out</a>
                                </div>
                            </div>
                        @endauth
                        <div class="col-md-9">
                            @yield('content')
                        </div>
                    </div>
                </div>
                
            </main>
        
    </div>
    
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> --}}
</body>
</html>
