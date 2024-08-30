@extends('admin.layouts.main')

@section('title')
    View Employer
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col" onclick="history.back()">
                <span class="text-decoration-none bg-primary p-1 text-white rounded-1" >
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
                                @if ($item->image == null)
                                    <img src="{{ asset('image/default_user.jpg') }}" class=" img-thumbnail rounded-circle"
                                        width="140px">
                                @else
                                    <img src="{{ asset('storage/company/' . $item->image) }}" width="140px"
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
                                            <b>Account Phone-</b> @if($item->company_phone) {{$item->company_phone}} @else No Data @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center p-2 bg-warning">
                                <p class="fw-bold ">Company Logo</p>
                                @if ($item->logo == null)
                                    <img src="{{ asset('image/default_user.jpg') }}" class=" img-thumbnail rounded-circle"
                                        width="140px">
                                @else
                                    <img src="{{ asset('storage/company/'. $item->logo) }}" width="140px"
                                        class=" img-thumbnail" style=" object-fit:cover;"/>
                                @endif
                            </div>
                            <div class="col bg-warning">
                                <div class=" d-flex align-items-center">
                                    <div class="p-3">
                                        <p class="mb-2 fw-bold p-2 shadow-sm">
                                            <b>Founder Name-</b>&nbsp; @if ($item->founder_name)
                                                {{$item->founder_name}}
                                            @else
                                                No Data
                                            @endif
                                        </p>
                                        <p class="mb-2 fw-bold p-2 shadow-sm">
                                            <b>Founded Date -</b>&nbsp;&nbsp; @if ($item->founded_date)
                                                {{$item->founded_date}}
                                            @else
                                                No Data
                                            @endif
                                        </p>
                                        <p class="mb-2 fw-bold p-2 shadow-sm">
                                            <b>Social Link &nbsp;&nbsp;&nbsp;&nbsp;-</b>&nbsp;&nbsp;&nbsp; @if ($item->website)
                                                <a href="https://{{$item->website}}" class="text-decoration-none">{{$item->website}}</a>
                                            @else
                                                No Data
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 shadow-sm rounded-2 my-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row m-2">
                                            <div class="col-6 my-2 ">Number of Employees</div>
                                            <div class="col-6 my-2 ">@if ($item->number_of_employees)
                                                {{$item->number_of_employees}}
                                            @else
                                                No Data
                                            @endif</div>
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
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="fw-bold fs-5 ">Company Description<p>
                                        <p class=" text-justify">
                                            @if ($item->company_description)
                                                @php
                                                    echo $item->company_description;
                                                @endphp
                                            @else
                                                <div class="text-center">No Data</div>
                                            @endif
                                        </p>    
                                    </div>
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