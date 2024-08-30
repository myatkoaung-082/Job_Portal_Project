@extends('admin.layouts.main')

@section('title')
    Professional Title
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row my-3">
            <div class="col-6 offset-3">

                <form action="{{route('admin#professioncreatefunc')}}" method="POST" class="p-3 shadow-lg mt-3 rounded-2">
                    @csrf
                    <div class="card-title mb-2">
                        <span class="text-decoration-none bg-primary p-1 text-white rounded-1">
                            <i class="fa-solid fa-rotate-left" onclick="history.back()"></i>Back 
                        </span>
                    </div>

                    <div class="mb-2 text-center">
                        <h3>Create Professional Title</h3>
                    </div>
                    
                    <div class="mb-2">
                        <label for="">Professional Title</label>
                        <input type="text" name="professionName" class="form-control @error('professionName')
                            is-invalid
                        @enderror" placeholder="Enter Professional Name" value="{{old('professionName')}}" required>
                        @error('professionName')
                            <span class="text-secondary">
                                {{$message;}}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="">Category Name</label>
                        <select name="category_name" class=" form-control" required>
                            <option value="" selected>Choose fields</option>
                            @foreach ($data as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-sm btn-primary p-2"><i class="fa-solid fa-plus"></i> Create</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection