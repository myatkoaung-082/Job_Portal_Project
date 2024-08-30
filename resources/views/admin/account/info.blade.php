@extends('admin.layouts.main')

@section('title')
    Account Info
@endsection

@section('content')
    <div class="row mt-5 shadow-sm">
        <div class="col-8 mx-auto">
            <div class="row mb-3">
                <div class="col">
                    <a href="{{ route('admin#dashboard') }}" class=" text-decoration-none bg-primary p-1 text-white rounded-1">
                        <i class="fa-solid fa-rotate-left"></i>Back
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-3 d-flex justify-content-center align-items-center">
                    @if (Auth::user()->image == null)
                        <img src="{{ asset('image/default_user.jpg') }}" class=" img-thumbnail rounded-circle"
                            width="100px">
                    @else
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" width="200px" height="200px"
                            class=" img-thumbnail" />
                    @endif
                </div>
                <div class="col-9">
                    <div class="mb-2">
                        <h3>Admin Profile</h3>
                    </div>
                    <div class="mb-2">
                        <i class="fa-solid fa-user"></i> - {{ Auth::user()->name }}
                    </div>
                    <div class="mb-2">
                        <i class="fa-solid fa-envelope"></i> - {{ Auth::user()->email }}
                    </div>
                    <div class="mb-2">
                        <i class="fa-solid fa-phone-volume"></i> - {{ Auth::user()->phone }}
                    </div>
                    <div class="mb-2">
                        <a href="{{ route('admin#updatePage', Auth::user()->id) }}">
                            <div class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i> Update</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
