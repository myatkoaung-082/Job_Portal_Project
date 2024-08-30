@extends('seeker.layouts.master')

@section('title')
    Home Page
@endsection

@section('content')
<div class="col-lg-9">
    @if (count($data) != 0)
        @foreach ($data as $d)
            <a href="{{ route('seeker#detailJob', [$d->id, $d->company_id]) }}"
                class="text-decoration-none text-dark ">

                <div
                    class="job-card shadow-sm  d-flex flex-column border border-1 rounded my-3 p-2 wow animate__fadeInRight">
                    <div class="job-card-top row justify-content-between">
                        <div class="col-10 py-2 ms-2" style="height: 70px">
                            <div class="row">
                                <div class="col-lg-1 me-4">
                                    @if ($d->logo)
                                        <img src="{{ asset('storage/company/' . $d->logo) }}"
                                            class="shadow-sm rounded" height="60" width="60"
                                            alt="" style="object-fit: cover;">
                                    @else
                                        <img src="{{ asset('image/default_user.jpg') }}"
                                            class="shadow-sm rounded" height="60" width="60"
                                            alt="" style="object-fit: cover;">
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="company-name fw-bold">{{ $d->name }}</h6>
                                    <span class="company-location text-muted fs-13"><i
                                            class="fa-solid fa-location-dot me-2"></i>{{ $d->township_name }}
                                        ,
                                        {{ $d->state_name }}</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <h5 class="fw-bold my-1 p-0 ms-2">{{ $d->professional_title_name }}</h5>

                    <div class="text-muted fs-13 mb-1 ms-2">
                        <span class="posted-time me-2"><i
                                class="fa-solid fa-clock me-2"></i>{{ $d->created_at->diffForHumans() }}</span>
                        <span class="view-count"><i class="fa-solid fa-eye me-2"></i>{{ $d->view_count }}
                            Viewer(s)</span>
                    </div>


                    <p class="job-card-description w-80 mb-3 text-break ms-2">
                        {{-- {{ Str::words($d->job_description, 10, '...') }} --}}
                        @php
                            echo Str::words($d->job_description, 40, '...');
                        @endphp

                    </p>
                    <div class="card-bottom row justify-content-between mt-2 ms-2">
                        <div class="col-6 p-0">
                            <span>
                                <i class="fa-solid fa-calendar-days"></i>
                                Deadline : <strong>{{ $d->apply_expire_date }}</strong>
                            </span>
                        </div>

                    </div>
                </div>
            </a>
        @endforeach
    @else
        <div class="row">
            <div
                class="col-lg-10 offset-1 d-flex justify-content-center align-items-center bg-primary text-light">
                <h5 class="py-2">There is no job for your searching!</h5 class="py-2">
            </div>
        </div>
    @endif
</div>
@endsection