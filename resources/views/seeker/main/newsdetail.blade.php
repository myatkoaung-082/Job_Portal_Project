@extends('seeker.layouts.master')

@section('title')
    News
@endsection

@section('content')
    <div class="container-fluid my-5">
        <div class="row my-5">

        </div>
        <div class="row my-5">

        </div>
        <div class="row justify-content-center my-3">
            <div class="col-3 d-flex justify-content-center align-items-center">
                <img src="{{ asset('storage/blogImage/' . $data->image) }}" alt="Image" width="250px" height="200px"
                    class=" img-thumbnails rounded shadow-sm">
            </div>
            <div class="col-9">
                <h5 class="mb-3 fw-bold">{{ $data->title }} <small class="mx-2 fw-medium">
                        <i class="fa-solid fa-eye fw-semibold"></i> {{ $data->view_count }} |
                        {{ $data->created_at->diffForHumans() }}
                    </small></h5>
                <p class="text-dark text-justify" style="width:60em; line-height:1.5em; text-indent:50px;">
                    {{ $data->description }}
                </p>
            </div>
            <div class="col-11 p-2 d-flex justify-content-end align-items-center">
                {{-- <small class="mx-2">
                    <i class="fa-solid fa-eye"></i> {{ $data->view_count }} |
                    {{$data->created_at->diffForHumans()}}
                </small> --}}
                <a href="{{ route('seeker#news') }}">
                    <div class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-arrow-left me-1"></i> <small>Back</small>
                    </div>
                </a>
            </div>
        </div>
        <div class="row my-5">

        </div>
    </div>
@endsection
