@extends('layouts.app')

@section('categories-active')
    active
@endsection

@section('title')
    Categories
@endsection

@section('content')

            <div class="card">
                <div class="card-header">Categories</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">S/N</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=  5 * ($categories->currentPage() - 1) + 1 @endphp
                            @forelse($categories as $category)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->description}}</td>
                                    <td>
                                        <select onChange="window.location.href=this.value">
                                            <option value="{{route('categories')}}">Actions</option>
                                            <option value="{{route('edit-category',$category->id)}}">Edit</option>
                                            <option value="{{route('show-delete-category',$category->id)}}">Delete</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                                <div class="alert alert-danger">There no categries</div>
                            @endforelse
                        </tbody>
                    </table>
                    {{$categories->links()}}
                </div>
            </div>
           
@endsection

    