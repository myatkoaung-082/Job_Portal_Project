@extends('seeker.layouts.master')

@section('title')
    Company Detail
@endsection

@section('content')
    <section class="content min-vh-100">
        @foreach ($companyData as $cd)
        <div class="company-profile">
            <div class="container-fluid background">
                <div class="company-header container">

                    <div class="row align-items-center">
                        <div class="col-lg-2 d-flex justify-content-center align-items-center border-end-1 border-primary">
                            <div class="company-logo rounded d-flex align-items-center bordeer border-1" height="120">
                                @if ($cd->logo)
                                    <img class="rounded border shadow-lg" src="{{asset('storage/company/'.$cd->logo)}}" width="130"
                                    alt="" style=" object-fit:cover;">
                                @else
                                    <img class="rounded border shadow-lg" src="{{asset('image/default_user.jpg')}}" width="130"
                                    alt="" style=" object-fit:cover;">
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-1 pe-0 d-flex" style="height: 130px;">
                            <div class="vr text-primary rounded" style="width: 3px;background-color: black;"></div>
                        </div>

                        <div class="col-lg-5 p-0">
                            <div class="info text-dark d-flex flex-column justify-content-center align-items-start ">
                                <h3 class="mb-3">{{$cd->name}}</h3>
                                <ul class="list-unstyled">
                                    @if ($cd->address || $cd->township_name || $cd->state_name)
                                        <li class="mb-2"><i class="fa-solid fa-location-dot me-2"></i> {{$cd->address}} | {{$cd->township_name}} | {{$cd->state_name}}</li>
                                    @else
                                        <li class="mb-2"></li>   
                                    @endif
                                    <li class="mb-2"><i class="fa-solid fa-clock me-2"></i>Member Since {{$userCreateAt->format('d-m-Y')}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row mt-2">
                                <div class="col-lg-2 offset-10" style="height: 160px;">
                                    <a href="{{ route('seeker#saveCompany', $cd->companyId) }}"
                                        class="btn btn-light text-primary"><i class="fa-solid fa-bookmark"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="container">
                <div class="row ">
                    <div class="col-lg-9 mt-2">
                        <div class="">
                            <h4 class="text-primary my-2">Company Summary</h4>
                            <p>
                                {{-- {{$cd->company_description}} --}}
                                @php
                                    echo $cd->company_description;
                                @endphp
                            </p>
                        </div>
                        <div class="mt-4">
                            <h4 class="text-center">Opening Jobs</h4>
                            <div class="jobCards">

                                <div class="row justify-content-evenly ">
                                    
                                    @if(count($companyJob) != 0)
                                        @foreach ($companyJob as $cj)
                                            <div class="col-12 wow animate__fadeInLeft">
                                                <a href="{{route('seeker#detailJob',[$cj->id, $cj->company_id])}}" class="text-decoration-none text-dark">
                                                    <div class="job-card  d-flex flex-column border border-1 rounded my-3 p-3 shadow-sm">
                                                        <div class="job-card-top row justify-content-between">
                                                            <div class="col-10 py-2">
                                                                <h3 class="px-2 text-primary">
                                                                    {{$cj->proTitle}}
                                                                </h3>
                                                            </div>
                                                            <div class="col-1 py-2 text-end ">
                                                                <i class="bi bi-bookmark"></i>
                                                            </div>
                                                        </div>
                                                        {{-- <p class="job-card-description px-2 text-dark">
                                                            @php
                                                                echo $cj->job_description;
                                                            @endphp
                                                        </p> --}}
                                                        <p class="job-card-description px-2 text-dark" >
                                                            {{-- {!!$d->job_description!!} --}}
                                                            {{-- {!!Str::words($d->job_description,20,'...')!!} --}}
                                                            {{-- {{Str::limit($d->job_description,100)}} --}}
                                                            @php
                                                                // echo  Str::words($d->job_description, 40, '...');
                                                                $text = strip_tags($cj->job_description);
                                                                echo Str::words($text, 40, '...');
                                                            @endphp
                                                        </p>
                                                        <div class="card-bottom row justify-content-between px-2">
                                                            <div class="col-6 text-black-50">
                                                                <strong>
                                                                    {{$cj->name}}
                                                                </strong>
                                                                <br>
                                                                <strong>
                                                                    {{$cj->salary}}
                                                                </strong>
                                                            </div>
                                                            <div class="col-6 text-end text-black-50">
                                                                <strong>Post: {{$cj->created_at->diffForHumans()}}</strong>
                                                                <br>
                                                                <span>
                                                                    <i class="bi bi-calendar2-week"></i>
                                                                    Deadline : <strong>{{$cj->apply_expire_date}}</strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="my-5">
                                            <div class="p-3 bg-primary text-light text-center rounded-2">
                                                <i class="fa-solid fa-triangle-exclamation"></i> No Jobs Found!
                                            </div>
                                        </div>
                                    @endif
                                
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 mt-2">
                        <div class="companyOverviewCard border rounded-4 overflow-hidden shadow-sm">

                            <div class="COcard-top position-relative">
                                <div
                                    class="COcard-border d-flex align-items-center justify-content-center shadow position-absolute top-0  border-2 border-gray bg-primary text-light">
                                    <h5>Company Overview</h5>
                                </div>
                            </div>


                            <div class="COcard-body p-3">
                                <div class="d-flex  mb-4 border-bottom-1">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-user me-2" style="width:20px;"></i>
                                        <span class="d-inline-block" >Owner</span>
                                    </div>
                                    <div class="flex-fill"></div>
                                    <div class="">
                                        <span>{{$cd->founder_name}}</span>
                                    </div>
                                </div>
                                <div class="d-flex  mb-4 border-bottom-1">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-calendar me-2" style="width:20px;"></i>
                                        <span class="d-inline-block" >Founded</span>
                                    </div>
                                    <div class="flex-fill"></div>
                                    <div class="">
                                        <span>{{$cd->founded_date}}</span>
                                    </div>
                                </div>
                                <div class="d-flex mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-industry me-2" style="width:20px;"></i>
                                        <span class="d-inline-block" >Industry</span>
                                    </div>
                                    <div class="flex-fill"></div>
                                    <div class="text-end">
                                        @foreach ($companyIndustry as $ci )
                                            <span>{{$ci->industry_name}}, </span> 
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-flex mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-globe me-2" style="width:20px;"></i>
                                        <span class="d-inline-block" >Website</span>
                                    </div>
                                    <div class="flex-fill"></div>
                                    <div class="">
                                        <span class="text-break">
                                            <a href="https://{{$cd->website}}" target="_blank">{{$cd->website}}</a>
                                        </span>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>


            </div>

            <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;" onclick="history.back()">
                    <i class="fa-solid fa-circle-left fs-4"></i>
                </button>
            </div>


        </div>
        @endforeach
    </section>
@endsection

@section('scriptcode')
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            // Check for success messages
            @if (session('saveSuccess'))
                Toast.fire({
                    icon: "success",
                    title: "{{ session('saveSuccess') }}"
                });
            @endif

            @if (session('saveFail'))
                Toast.fire({
                    icon: "error",
                    title: "{{ session('saveFail') }}"
                });
            @endif
        });
    </script>

    <script>
        $(document).ready(function() {

        wow = new WOW({
            boxClass: 'wow', // default
            animateClass: 'animated', // default
            offset: 0, // default
            mobile: true, // default
            live: true // default
        })
        wow.init();
    })
    </script>
@endsection