@extends('employer.layouts.master')

@section('title')
    Home Page
@endsection

@section('content')
<div class="container-fluid">
    <div class="cards d-flex justify-content-around mt-5">
        <div class="card job-card text-dark shadow-sm rounded bg-light" style="width: 10rem">
            <div class="card-body d-flex flex-column p-3 fs-5">
                <span class="fw-bold ms-1">{{ count($activeJobs) }} + <i
                        class="fa-solid fa-database ms-3 fs-2"></i></span>
                <span class="fw-bold text-primary">Active Jobs</span>
            </div>
        </div>
        <div class="card job-card text-dark shadow-sm rounded bg-light" style="width: 10rem">
            <div class="card-body d-flex flex-column p-3 fs-5">
                <span class="fw-bold ms-1">{{ count($companies) }} + <i
                        class="fa-solid fa-building ms-3 fs-2"></i></span>
                <span class="fw-bold text-primary">Companies</span>
            </div>
        </div>
        <div class="card job-card text-dark shadow-sm rounded bg-light" style="width: 10rem">
            <div class="card-body d-flex flex-column p-3 fs-5">
                <span class="fw-bold ms-1">{{ count($seekers) }} + <i
                        class="fa-solid fa-user-graduate ms-3 fs-2"></i></span>
                <span class="fw-bold text-primary">Candidates</span>
            </div>
        </div>
    </div>


    <h3 class="text-center fw-bold my-3">Our Partners<i class="fa-solid fa-users ms-2"></i></h3>

    <div class="swiper container bg-white shadow-sm border border-1  py-3 rounded">
        <div class="swiper-wrapper">
            @foreach ($companyLogos as $c)
                <div class="swiper-slide d-flex"><a href="{{ route('employer#headerCompanyDetail1', $c->user_id) }}"><img
                            src="{{ asset('storage/company/' . $c->logo) }}" class="rounded shadow-sm"></a></div>
                {{-- <div class="swiper-slide d-flex"><a href="{{route('seeker#companydetail1', $c->user_id)}}"><img src="{{ asset('storage/company/'.$c->logo) }}" class="rounded shadow-sm"></a></div>
            <div class="swiper-slide d-flex"><a href="{{route('seeker#companydetail1', $c->user_id)}}"><img src="{{ asset('storage/company/'.$c->logo) }}" class="rounded shadow-sm"></a></div> --}}
            @endforeach

            <!-- Add more slides as needed -->
        </div>

    </div>

    <h3 class="text-center fw-bold my-3">Latest Jobs <i class="fa-solid fa-layer-group ms-2 text-primary"></i></h3>

    <div class="container mb-5">
        <div class="row g-3 mb-4">
            @if (count($latestJobs) != 0)
                @foreach ($latestJobs as $lj)
                    <div class="col-lg-3  mx-auto job-card">
                        <a href="{{ route('employer#headerDetail', [$lj->id, $lj->company_id]) }}"
                            class="text-decoration-none d-inline ">
                            <div class="companyJobCard overflow-visible border border-1 rounded p-3 shadow-sm" style="height: 135px">
                                <div class="row">
                                    <div class="col-4" style="height: 70px;">
                                        <span class="company-logo w-100" style="height: 75px;">
                                            @if ($lj->logo)
                                                <img src="{{ asset('storage/company/' . $lj->logo) }}"
                                                    class="rounded shadow-sm w-100 h-100" alt="" />
                                            @else
                                                <img src="{{ asset('image/default_user.jpg') }}"
                                                    class="rounded shadow-sm w-100 h-100" alt="" />
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-8">
                                        <div class="company-detail d-flex flex-column justify-content-center align-items-start"
                                            style="height: 100%">
                                            <h6 class="company-job-title text-black">
                                                {{Str::words($lj->professional_title_name,3,'...')}} 
                                                {{-- {{ $lj->professional_title_name }} --}}
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