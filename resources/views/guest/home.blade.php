@extends('guest.layouts.main')

@section('title')
    Guest
@endsection

@section('content')
    <div class="container-fluid">
        <div class="cards mt-3" id="cardsection">
            <div class="card job-card text-dark shadow-sm rounded bg-light" >
                <div class="card-body d-flex flex-column p-4 fs-5 mb-lg-0 mb-sm-3">
                    <span class="fw-bold ms-1 text-center">{{ count($activeJobs) }} + <i
                            class="fa-solid fa-database ms-3 fs-2"></i></span>
                    <span class="fw-bold text-primary text-center">Active Jobs</span>
                </div>
            </div>
            <div class="card job-card text-dark shadow-sm rounded bg-light" >
                <div class="card-body d-flex flex-column p-4 fs-5 mb-lg-0 mb-sm-3">
                    <span class="fw-bold ms-1 text-center">{{ count($companies) }} + <i
                            class="fa-solid fa-building ms-3 fs-2"></i></span>
                    <span class="fw-bold text-primary text-center">Companies</span>
                </div>
            </div>
            <div class="card job-card text-dark shadow-sm rounded bg-light" >
                <div class="card-body d-flex flex-column p-4 fs-5 mb-lg-0 mb-sm-3">
                    <span class="fw-bold ms-1 text-center">{{ count($seekers) }} + <i
                            class="fa-solid fa-user-graduate ms-3 fs-2"></i></span>
                    <span class="fw-bold text-primary text-center">Candidates</span>
                </div>
            </div>
        </div>

        {{-- <div class="container-fluid min-vh-100 mt-5"> --}}

            <div class="row justify-content-evenly my-5">
                <div class="card col-lg-4 shadow-sm" >
                    <img src="{{asset('admin/images/hiring.jpg')}}" style="height: 300px;width:400px;margin-left:87px" class="card-img" alt="...">
                    <div class="card-img-overlay">
                      <h3 class="card-title fw-bolder">Hiring?</h3>
                      <p class="card-text fw-bold">Start find your good partners here.</p>
                      <a href="{{route('auth#registerPage')}}" class="btn btn-primary">Company Sign Up</a>
                    </div>
                  </div>
                <div class="card col-lg-4 shadow-sm" >
                    <img src="{{asset('admin/images/seeking.jpg')}}" style="height: 300px;width:400px;margin-left:87px" class="card-img" alt="...">
                    <div class="card-img-overlay">
                      <h3 class="card-title fw-bolder">Seeking For?</h3>
                      <p class="card-text fw-bold">Get your suitable place here.</p>
                      <a href="{{route('auth#registerPage')}}" class="btn btn-primary">Seeker Sign Up</a>
                    </div>
                  </div>

            </div>

            <div class="row my-5 justify-content-center ">
                <div class="col-lg-5 text-center">
                    <img src="{{asset('admin/images/undraw_certificate_re_yadi.svg')}}" class="rounded-3" style="height: 200px;width:200px;" alt="">
                </div>
                <div class="col-lg-5 d-flex flex-column justify-content-center box-1">
                    <h3 class="fw-bolder">Company &mdash; How To</h3>
                    <ol class="list-unstyled p-2">
                        <li class="fw-bold">Create an Account
                            <ul>
                                <li class="fw-normal">Sign up and set up your company profile.</li>
                            </ul>
                        </li>
                        <li class="fw-bold">Post a Job
                            <ul>
                                <li class="fw-normal">List your job openings with detailed descriptions.</li>
                            </ul>
                        </li>
                        <li class="fw-bold">Find Candidates
                            <ul>
                                <li class="fw-normal">Browse through applications and find the perfect fit.</li>
                            </ul>
                        </li>

                    </ol>
                </div>
            </div>

            <div class="row my-5 flex-row-reverse justify-content-center ">
                <div class="col-lg-5 text-center">
                    <img src="{{asset('admin/images/undraw_predictive_analytics_re_wxt8.svg')}}" class="rounded-3" style="height: 200px;width:200px;" alt="">
                </div>
                <div class="col-lg-5 d-flex flex-column justify-content-center box-1">
                    <div class="w-75 text-md-center">
                        <h3 class="fw-bolder">Seeker &mdash; How To</h3>
                    <ol class="list-unstyled p-2 text-md-start">
                        <li class="fw-bold">Create Your Profile
                            <ul>
                                <li class="fw-normal">Sign up and build a detailed profile to showcase your skills and experience.</li>
                            </ul>
                        </li>
                        <li class="fw-bold">Search for Jobs
                            <ul>
                                <li class="fw-normal">Use our search tool to find job opportunities that match your career goals.</li>
                            </ul>
                        </li>
                        <li class="fw-bold">Apply & Get Hired
                            <ul>
                                <li class="fw-normal">Apply for jobs and connect with company directly through our platform.</li>
                            </ul>
                        </li>

                    </ol>
                    </div>
                </div>
            </div>

        {{-- </div> --}}


        <h3 class="text-center fw-bold my-3">Our Partners<i class="fa-solid fa-users ms-2"></i></h3>

        <div class="swiper container bg-white shadow-sm border border-1 py-3 rounded" id="swiper">
            <div class="swiper-wrapper">
                @foreach ($companyLogos as $c)
                    <div class="swiper-slide d-flex me-2"><a href="{{ route('guest#companydetail1', $c->user_id) }}"><img
                                src="{{ asset('storage/company/' . $c->logo) }}" class="rounded shadow-sm"></a></div>
                @endforeach
                <!-- Add more slides as needed -->
            </div>
        </div>

        <h3 class="text-center fw-bold my-3">Latest Jobs <i class="fa-solid fa-layer-group ms-2 text-primary"></i></h3>

        <div class="container mb-5">
            <div class="row g-3 mb-4">
                @if (count($latestJobs) != 0)
                    @foreach ($latestJobs as $lj)
                        <div class="col-lg-3 job-card mx-auto">
                            <a href="{{ route('guest#detailJob', [$lj->id, $lj->company_id]) }}"
                                class="text-decoration-none d-inline">
                                <div class="companyJobCard overflow-visible border border-1 rounded p-3 shadow-sm">
                                    <div class="row">
                                        {{-- <img src="{{ asset('image/default_user.jpg') }}"
                                                        class="rounded w-100" alt="" /> --}}
                                        <div class="col-4">
                                            <div class="company-logo w-100 shadow-sm" style="height: 75px;">

                                                @if ($lj->logo)
                                                    <img src="{{ asset('storage/company/' . $lj->logo) }}"
                                                        class="rounded w-100 h-100" alt="" />
                                                @else
                                                    <img src="{{ asset('image/default_user.jpg') }}"
                                                        class="rounded w-100 h-100" alt="" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="company-detail d-flex flex-column justify-content-center align-items-start"
                                                style="height: 100%">
                                                <h6 class="company-job-title text-black">
                                                    {{ $lj->professional_title_name }}
                                                </h6>
                                                <h6 class="company-name text-primary">{{ $lj->company_name }}</h6>
                                                <span
                                                    class="my-1 fs-13 text-muted">{{ $lj->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="my-5">
                        <div class="p-3 bg-info text-light text-center rounded-2">
                            <i class="fa-solid fa-triangle-exclamation"></i> No Jobs Found!
                        </div>
                    </div>
                @endif




            </div>

            {{ $latestJobs->appends(request()->query())->links() }}

        </div>
       

        {{-- <div class="container mb-5">
            <div class="row g-3 mb-4">
                @if (count($latestJobs) != 0)
                    @foreach ($latestJobs as $lj)
                        <div class="col-lg-3 col-md-6 mx-auto">
                            <a href="{{ route('guest#detailJob', [$lj->id, $lj->company_id]) }}"
                                class="text-decoration-none d-inline">
                                <div class="companyJobCard overflow-visible border border-1 rounded p-3 shadow-sm">
                                    <div class="row">
                                        <div class="col-4">
                                            <span class="company-logo w-100">
                                                @if ($lj->logo)
                                                    <img src="{{ asset('storage/company/' . $lj->logo) }}"
                                                        class="rounded shadow-sm w-100" alt="" />
                                                @else
                                                    <img src="{{ asset('image/default_user.jpg') }}"
                                                        class="rounded shadow-sm w-100" alt="" />
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-8">
                                            <div class="company-detail d-flex flex-column justify-content-center align-items-start"
                                                style="height: 100%">
                                                <h6 class="company-job-title text-black">
                                                    {{ $lj->professional_title_name }}
                                                </h6>
                                                <h6 class="company-name text-primary">{{ $lj->company_name }}</h6>
                                                <span
                                                    class="my-1 fs-13 text-muted">{{ $lj->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="my-5">
                        <div class="p-3 bg-info text-light text-center rounded-2">
                            <i class="fa-solid fa-triangle-exclamation"></i> No Jobs Found!
                        </div>
                    </div>
                @endif

            </div>

            {{ $latestJobs->appends(request()->query())->links() }}

        </div> --}}
    </div>
@endsection

@section('scriptcode')
    <script>
        const swiper = new Swiper('.swiper', {
            slidesPerView: 6,
            loop: true,
            centeredSlides: true,
            speed: 7000,
            allowTouchMove: false,
            disableOnInteraction: false,
            autoplay: {
                delay: 1, // milliseconds

            },
        });
    </script>
@endsection
