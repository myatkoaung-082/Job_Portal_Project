@extends('admin.layouts.main')

@section('title')
    Category
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row my-3">
            <div class="col-6 offset-3">

                <form action="{{route('admin#categorycreate')}}" method="POST" class="p-3 shadow-lg mt-3 rounded-2">
                    @csrf
                    <div class="card-title mb-2">
                        <span class="text-decoration-none bg-primary p-1 text-white rounded-1">
                            <i class="fa-solid fa-rotate-left" onclick="history.back()"></i>Back 
                        </span>
                    </div>

                    <div class="mb-2 text-center">
                        <h3>Create Job Category</h3>
                    </div>
                    
                    <div class="mb-2">
                        <label for="">Category</label>
                        <input type="text" name="categoryName" class="form-control @error('categoryName')
                            is-invalid
                        @enderror" required placeholder="Enter your category name" value="{{old('categoryName')}}">
                        @error('categoryName')
                            <span class="text-secondary">
                                {{$message}}
                            </span>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-sm btn-primary p-2"><i class="fa-solid fa-plus"></i> Create</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection