@extends('guest.layouts.main')

@section('title')
    News
@endsection

@section('content')
    <div class="container-fluid min-vh-100">
        {{-- <div class="row my-lg-5 my-md-5">

        </div>
        <div class="row my-lg-5 my-md-5">

        </div> --}}
        
        <div class="row my-lg-5 justify-content-center">
            <div class="row my-3 my-lg-5">
                <div class="col-lg-3 col-sm-12 col-md-3 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('storage/blogImage/'.$data->image) }}" alt="Image" width="150px" height="100px" class=" img-thumbnails rounded">
                </div>
                <div class="col-lg-6 col-sm-12 col-md-9 cdeatail">
                    <h5 class="text-center mt-2">{{$data->title}}</h5>
                    <p class="px-2">
                        {{$data->description}}
                    </p>
                </div>
                <div class="col-12 col-lg-9 p-2 d-flex justify-content-end align-items-center">
                    <small class="mx-2">
                        <i class="fa-solid fa-eye"></i> {{ $data->view_count }} |
                        {{$data->created_at->diffForHumans()}}
                    </small>
                    <a href="{{ route('guest#news') }}">
                        <div class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-arrow-left me-1"></i> <small>Back</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row my-lg-5">

        </div>
    </div>
@endsection