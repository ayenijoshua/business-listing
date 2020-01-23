@extends('layouts.app')

@section('create-listing-active')
    active
@endsection

@section('title')
    Edit listing
@endsection

@section('content')

    

    <div class="card">
        <div class="card-header">Edit Listing</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

                <form method="POST" action="{{route('update-listing',$listing->id)}}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Business name</label>
                        <input type="text" name="name" value="{{old('name') ?? $listing->name}}" class="form-control" id="exampleFormControlInput1" placeholder="Busines name">
                        @error('name')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Business categories</label>
                        <select name="categories[]" class="form-control" multiple>
                            @foreach($categories as $category)
                                <option @if($listing->categories->contains($category->id)) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('categories')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Business Email</label>
                        <input type="email" name="email" value="{{old('email') ?? $listing->email}}" class="form-control" id="exampleFormControlInput1" placeholder="business email">
                        @error('email')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>

                    {{-- <div class="form-group">
                        <label for="exampleFormControlInput1">Business phone</label>
                        <input type="text" name="phone" class="form-control" id="exampleFormControlInput1" placeholder="business phone">
                        @error('phone')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div> --}}

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Business website url</label>
                        <input type="text" name="url" class="form-control" value="{{old('url') ?? $listing->url}}" id="exampleFormControlInput1" placeholder="website url">
                        @error('url')
                            <span class="invalid-feedback" style="color:red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Business description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="business description">{{old('description') ?? $listing->description}}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Business address</label>
                        <textarea class="form-control" name="address" rows="3" placeholder="business description">{{old('address') ?? $listing->address}}</textarea>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Business phones</label>
                        <textarea class="form-control" name="phones" rows="3" placeholder="business phones (seperated with comma)">{{old('phones') ?? $listing->phones}}</textarea>
                        @error('phones')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div>

                    {{-- <div class="form-group">
                            <label for="exampleFormControlTextarea1">Business Logos/Images</label>
                        <input type="file" multiple name="images" class="form-control">
                        @error('images')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span><br>
                        @enderror
                    </div> --}}
                    <div class="form-group col-md-3">
                        <button type="submit" class="form-control btn btn-primary">Submit</button>
                    </div>
                </form>
        </div>
    </div>
           
@endsection
