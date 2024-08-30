@extends('employer.layouts.master')

@section('title')
    News
@endsection

@section('content')
    <div class="container-fluid min-vh-100">
        <div class="row">
            <div class="col mt-2">
                <form action="{{ route('employer#news') }}" method="get" class="d-flex justify-content-end align-items-center me-2">
                    <div class="d-flex justify-content-end align-items-center">
                        <input type="text" name="key1" class="form-control me-2" value="{{ request('key1') }}" id="" placeholder="content or phrase...">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center mt-3 gap-3">
            @if(count($data) != 0)
                @foreach ($data as $item)
                
                    <div class="col-5 shadow-sm p-3 my-2 job-card rounded wow">
                        <div class="row">
                            <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                                <img src="{{ asset('storage/blogImage/'.$item->image) }}" alt="Image" width="150px" height="100px" class="mb-3 img-thumbnails rounded shadow-sm">
                                <p class="mx-2" style="font-size: 11px;">
                                    <i class="fa-solid fa-eye"></i> {{ $item->view_count }} |
                                    {{$item->created_at->diffForHumans()}}
                                </p>
                            </div>
                            <div class="col-9">
                                <h5 class=" text-dark fw-bold">{{$item->title}}</h5>
                                <p class="text-justify " style="width:25em; line-height:1.2em; text-align:justify;">
                                    {{Str::words($item->description,40,'...')}}
                                </p>
                            </div>
                            <div class="col-12 p-2 d-flex justify-content-end align-items-center">
                                {{-- <small class="mx-2">
                                    <i class="fa-solid fa-eye"></i> {{ $item->view_count }} |
                                    {{$item->created_at->diffForHumans()}}
                                </small> --}}
                                <a href="{{ route('employer#details',$item->id) }}">
                                    <div class="btn btn-sm btn-primary">
                                         <small>See More</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>    
                
                @endforeach
            @else
                <div class="container my-5">
                    <div class="row my-5">
                        <div class="col-6 offset-3 text-center bg-secondary text-white p-5 fs-3 rounded-1">
                            <i class="fa-solid fa-warning"></i> No Posts
                        </div>
                    </div>
                </div>
            @endif
            {{ $data->appends(request()->query())->links() }}
        </div>
        
    </div>
@endsection