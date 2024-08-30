@extends('employer.layouts.master')

@section('title')
    Companies
@endsection

@section('content')
    <div class="container mb-5">
        <div class="row my-5">
            @foreach ($data as $d)
                <div class="col-4 my-4">
                    <div class="company-card position-relative overflow-visible border border-1 rounded p-3 shadow-sm">
                        <div class="row ">
                            <div class="col-4">
                                <span class="company-logo w-100 ">
                                    @if ($d->logo)
                                        <img src="{{ asset('storage/company/' . $d->logo) }}" class="rounded shadow-sm"
                                            alt="" style="width: 100px; height:100px;">
                                    @else
                                        <img src="{{ asset('image/default_user.jpg') }}" alt=""
                                            class="rounded shadow-sm" alt="" style="width: 100px; height:100px;">
                                    @endif

                                </span>
                            </div>
                            <div class="col-8 py-2">
                                <div class="company-detail d-flex flex-column justify-content-center align-items-start"
                                    style="height: 100%;">
                                    <a href="" class="text-decoration-none ">
                                        <h5 class="company-name text-primary">
                                            {{ $d->name }}
                                        </h5>
                                    </a>
                                    <span class="my-1 fs-13 "><i class="bi bi-geo-alt me-2"></i>{{ $d->township_name }},
                                        {{ $d->state_name }}</span>
                                    <span class="lh-sm mb-2 fs-13"><i
                                            class="bi bi-list-check me-2"></i>{{ $d->address }}</span>


                                </div>
                            </div>

                        </div>



                        <div class="position-absolute more-info d-flex justify-content-center w-100" style="left: 0;">
                            <a href="{{ route('employer#companydetail', $d->user_id) }}"
                                class="btn btn-primary text-white rounded-4">
                                More info <i class="bi bi-arrow-right-circle"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach


        </div>




    </div>
@endsection
