@extends('admin.layouts.main')

@section('title')
    News
@endsection

@section('content')

    {{-- notification  --}}
    <div class="row">
        @if(session('createSuccess'))
            <div class="col">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong><i class="fa-check fa-solid"></i> {{ session('createSuccess') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('deleteSuccess'))
            <div class="col">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong><i class="fa-check fa-solid"></i> {{ session('deleteSuccess') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>

    {{-- search and dashboard function  --}}
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-2 ps-4">All Posts - {{ $data->total() }}</div>
        <div class="col-4"></div>
        <div class="col-6">
            <form action="{{ route('blog#list') }}" method="get" class="d-flex justify-content-end align-items-center me-2">
                <div class="d-flex justify-content-end align-items-center mb-2">
                    <input type="text" name="key1" class="form-control me-2" value="{{ request('key1') }}" id="" placeholder="Enter Title or Phrase...">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>
    </div>
    {{-- end search and dashboard function  --}}

    <div class="row">

        {{-- create blog post  --}}
            <div class="col-4 bg-light">
                <form action="{{ route('blog#create') }}" method="post" class="p-3" style="font-size: 1rem" enctype="multipart/form-data">
                    @csrf
                    <div class=" mb-3">
                        <label for="title">Post Title</label>
                        <input type="text" name="title" id="" class="form-control @error('title') is-invalid  @enderror" placeholder="Enter post title..." style="font-size: .8rem">
                        @error('title')
                            <div class=" invalid-feedback ">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="description">Post Description</label>
                        <textarea name="description" id="" cols="20" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Enter post description..." style="font-size: .8rem"></textarea>
                        @error('description')
                            <div class=" invalid-feedback ">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="image">Post Image</label>
                        <input type="file" name="image" id="" class="form-control @error('image') is-invalid @enderror" style="font-size: .8rem">
                        @error('image')
                            <div class=" invalid-feedback ">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <input type="submit" value="Create" class="btn btn-sm btn-primary">
                    </div>
                </form>
            </div>
        {{-- end create blog post  --}}

        {{-- view upload post  --}}
        <div class="col-8 bg-light p-3" style="font-size: 1rem">
            @if(count($data) != 0)
                @foreach ($data as $item)
                    <div class="post p-3 shadow-sm mb-3">
                        <div class="row mb-2">
                            <div class="col-8">
                                <h5>{{$item->title}}</h5>
                            </div>
                            <div class="col-4 text-end">
                                <i class="fa-solid fa-eye"></i> {{ $item->view_count }} |
                                {{$item->created_at->diffForHumans()}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 text-center">
                                <img src="{{ asset('storage/blogImage/'.$item->image) }}" alt="Image" width="130px" height="100px" class=" img-thumbnails">
                            </div>
                            <div class="col-9 align-items-center">
                                <p class="text-dark text-justify" style="width:35em; line-height:1.3em; letter-spacing:1.5px;">
                                    {{Str::words($item->description,40,'...')}}
                                </p>
                            </div>
                        </div>
                        <div class="text-end">
                            
                            <a href="{{ route('blog#delete',$item->id) }}">
                                <div class="btn btn-sm btn-danger text-light">
                                    <i class="fa-solid fa-trash"></i>
                                </div>
                            </a>

                            <a href="{{ route('blog#details',$item->id) }}">
                                <div class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-file-lines"></i> <small>See More</small>
                                </div>
                            </a>
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
        {{-- end view --}}
    </div>
@endsection
