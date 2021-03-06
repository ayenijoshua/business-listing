@extends('layouts.app')

@section('listings-active')
    active
@endsection

@section('title')
    Listings
@endsection

@section('content')

            <div class="card">
                <div class="card-header">Listings</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">website</th>
                            <th scope="col">Address</th>
                            <th scope="col">categories</th>
                            <th scope="col">phones</th>
                            <th scope="col">Description</th>
                            <th scope="col">Views</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @php $i=  5 * ($listings->currentPage() - 1) + 1 @endphp
                            @forelse($listings as $listing)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>{{$listing->name}}</td>
                                    <td>{{$listing->email}}</td>
                                    <td>
                                        @if($listing->is_deactived)
                                            Deactivated
                                        @else
                                            Activated
                                        @endif
                                    </td>
                                    <td>{{$listing->url}}</td>
                                    <td><textarea disabled>{{$listing->address}}</textarea></td>
                                    <td>
                                        <select class="">
                                            @foreach($listing->categories as $category)
                                                <option>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><textarea disabled>{{$listing->phones}}</textarea></td>
                                    <td>{{$listing->description}}</td>
                                    <td>{{$listing->view_count}}</td>
                                    <td>
                                        <select onChange="window.location.href=this.value">
                                            <option value="{{route('listings')}}">Actions</option>
                                            <option value="{{route('edit-listing',$listing->id)}}">Edit</option>
                                            @if($listing->is_deactived)
                                                <option value="{{route('show-activate-listing',$listing->id)}}">Activate</option>
                                            @else
                                                <option value="{{route('show-deactivate-listing',$listing->id)}}">De-activate</option>
                                            @endif
                                            <option value="{{route('show-delete-listing',$listing->id)}}">Delete</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <div class="alert alert-danger">There no categries</div>
                                    </td>
                                </tr>
                                
                            @endforelse
                        </tbody>
                    </table>
                    {{$listings->links()}}
                </div>
            </div>
           
@endsection

    