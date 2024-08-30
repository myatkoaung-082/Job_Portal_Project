@extends('admin.layouts.main')

@section('title')
    News
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if(session('updateSuccess'))
                <div class="col">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong><i class="fa-check fa-solid"></i> {{ session('updateSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

        </div>
        <div class="row">
            <div class="col-6 offset-3">
                <form action="{{ route('blog#update',$data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2 text-center">
                        <h3>Manage Blog Post</h3>
                    </div>
                    <div class="mb-2 text-center">
                        <img src="{{ asset('storage/blogImage/'.$data->image) }}" alt="image" width="200px" class=" img-thumbnails">
                    </div>
                    <div class="mb-2">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title',$data->title) }}" class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                            <div class=" invalid-feedback ">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="5" class="form-control @error('description') is-invalid @enderror">{{old('description',$data->description)}}</textarea>
                        @error('description')
                            <div class=" invalid-feedback ">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="image">Post Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" >
                        @error('image')
                            <div class=" invalid-feedback ">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2 text-center">
                        <a href="{{ route('blog#list') }}" class="btn btn-sm btn-primary">Back</a>
                        <input type="submit" value="Update" class="btn btn-sm btn-info">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection