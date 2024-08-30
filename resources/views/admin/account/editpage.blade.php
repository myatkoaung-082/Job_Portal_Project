@extends('admin.layouts.main')

@section('titel')
    Account Edit Page
@endsection

@section('content')
    <div class="row">
        @if (session('updateSuccess'))
            <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fa-check fa-solid"></i> {{ session('updateSuccess') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
    <div class="row mt-3 shadow-sm">
        <div class="col-8 mx-auto">
            <div class="row mb-3">
                <div class="col">
                    <a href="{{ route('admin#info') }}" class=" text-decoration-none bg-info p-1 text-white rounded-1">
                        <i class="fa-solid fa-rotate-left"></i>Back
                    </a>
                </div>
            </div>
            <form action="{{ route('admin#update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <div class="mb-2">
                            @if ($data->image == null)
                                @if ($data->gender == 'male')
                                    <img src="{{ asset('image/default_user.jpg') }}" class=" img-thumbnail rounded-circle"
                                        width="100px">
                                @else
                                    <img src="{{ asset('image/female_default_user.jpg') }}"
                                        class=" img-thumbnail rounded-circle" width="100px">
                                @endif
                            @else
                                <img src="{{ asset('storage/' . $data->image) }}" width="200px" height="200px"
                                    class=" img-thumbnail" />
                            @endif
                        </div>
                    </div>
                    <div class="col-9">

                        <div class="col-8">
                            <div class="mb-2">
                                <h3>Admin Profile</h3>
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <i class="fa-solid fa-user me-2"></i><input type="text" name="name"
                                    value="{{ old('name', $data->name) }}"
                                    class="form-control @error('name') is-invalid @enderror" >
                                @error('name')
                                    <div class=" invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <i class="fa-solid fa-envelope me-2"></i><input type="text" name="email"
                                    value="{{ old('email', $data->email) }}"
                                    class=" disabled form-control @error('email') is-invalid @enderror" disabled>
                                @error('email')
                                    <div class=" invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-2 d-flex align-items-center">
                                <i class="fa-solid fa-phone-volume me-2"></i><input type="text" name="phone"
                                    value="{{ old('phone', $data->phone) }}"
                                    class=" form-control @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class=" invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-2 d-flex align-items-center">
                                <i class="fa-regular fa-image me-2"></i><input type="file" name="image" id="image">
                                @error('image')
                                    <div class=" invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <button type="submit" class=" btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i>
                                    Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
