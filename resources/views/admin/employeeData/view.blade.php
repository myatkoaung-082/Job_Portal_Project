@extends('admin.layouts.main')

@section('title')
    Employees
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col" onclick="history.back()">
            <span class="text-decoration-none bg-primary p-1 text-white rounded-1">
                <i class="fa-solid fa-rotate-left" ></i>Back 
            </span>
        </div>
    </div>
    <div class="row my-2">
        <div class="col">
            @if (count($data)!= 0)
                @foreach ($data as $item)
                    <div class="row">
                        <div class="col text-center p-2 bg-warning">
                            <p class="fw-bold">Profile Image</p>
                            @if ($item->profile_image == null)
                                <img src="{{ asset('image/default_user.jpg') }}" class=" img-thumbnail rounded-circle"
                                    width="140px">
                            @else
                                <img src="{{ asset('storage/seeker/' . $item->profile_image) }}" width="140px"
                                    class=" img-thumbnail" style=" object-fit:cover;"/>
                            @endif
                        </div>
                        <div class="col bg-warning">
                            <div class=" d-flex align-items-center">
                                <div class="p-3">
                                    <p class="mb-2 fw-bold p-2 shadow-sm">
                                        <b>Account Name -</b> {{$item->name}}
                                    </p>
                                    <p class="mb-2 fw-bold p-2 shadow-sm">
                                        <b>Account Email-</b> <a href="https://www.gmail.com" class="text-decoration-none">{{$item->email}}</a>
                                    </p>
                                    <p class="mb-2 fw-bold p-2 shadow-sm">
                                        <b>Account Phone-</b> @if($item->phone) {{$item->phone}} @else No Data @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center p-2 bg-warning">
                            <p class="fw-bold ">Resume</p>
                            @if ($item->resume == null)
                                <img src="{{ asset('image/default_user.jpg') }}" class=" img-thumbnail rounded-circle"
                                    width="140px">
                            @else
                                <embed src="{{ asset('storage/seeker/' . $item->resume) }}" type="application/pdf" width="100%"
                                    height="200px">
                            @endif
                        </div>
                        <div class="col bg-warning">
                            <div class=" d-flex align-items-center">
                                <div class="p-3">
                                    <p class="mb-2 fw-bold p-2 shadow-sm">
                                        <b>Profession -</b> @if ($item->professional_title_name)
                                            {{$item->professional_title_name}}
                                        @else
                                            No Data
                                        @endif
                                    </p>
                                    <p class="mb-2 fw-bold p-2 shadow-sm">
                                        <b>Gender&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -</b> @if ($item->gender)
                                            {{$item->gender}}
                                        @else
                                            No Data
                                        @endif
                                    </p>
                                    {{-- <p class="mb-2 fw-bold p-2 shadow-sm">
                                        <b>NRC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -</b> @if ($item->nrc)
                                            {{$item->nrc}}
                                        @else
                                            No Data
                                        @endif
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 bg-info rounded-2 my-auto">
                            <div class="row">
                                <div class="col-6 my-2 ">Address</div>
                                <div class="col-6 my-2 ">@if ($item->address)
                                    {{$item->address}}
                                @else
                                    No Data
                                @endif</div>
                                <div class="col-6 my-2 ">Township</div>
                                <div class="col-6 my-2 ">@if ($item->township_name)
                                    {{$item->township_name}}
                                @else
                                    No Data
                                @endif</div>
                                <div class="col-6 my-2 ">State & Region</div>
                                <div class="col-6 my-2 ">@if ($item->state_name)
                                    {{$item->state_name}}
                                @else
                                    No Data
                                @endif</div>
                            </div>
                        </div>
                        <div class="col-6 bg-warning">
                            <div class="row">
                                <div class="col-6 my-2 ">Martial Status</div>
                                <div class="col-6 my-2 ">@if ($item->martial_status)
                                    {{$item->martial_status}}
                                @else
                                    No Data
                                @endif</div>
                                <div class="col-6 my-2 ">Date of Birth</div>
                                <div class="col-6 my-2 ">@if ($item->dob)
                                    {{$item->dob}}
                                @else
                                    No Data
                                @endif</div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                    
            @endif
        </div>
    </div>
</div>
@endsection