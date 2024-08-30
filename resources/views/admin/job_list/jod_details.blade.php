@extends('admin.layouts.main')

@section('title')
    Admin Job Detail
@endsection

@section('content')
    <section class="content min-vh-100 mb-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <button class="btn btn-outline-primary border-0 my-3" onclick="history.back()">
                        <i class="fa-solid fa-circle-left me-2"></i>Back
                    </button>
                </div>
            </div>

            <div class="job-title-card d-flex justify-content-between bg-white border border-1 rounded-4 shadow-sm p-4">
                <div class="">
                    <h3>{{ $Job->professional_title_name }} | {{ $Job->gender }} - <span>({{ $Job->vacancy }})</span> Posts
                    </h3>
                    <h5 class="company-name mb-3 text-info">{{ $Job->company_name }}</h5>
                    <div class="">
                        <span class="posted-time me-2"><i
                                class="fa-solid fa-clock me-2"></i>{{ $Job->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-lg-9">
                    <div class="jobDescription ps-5">
                        <h4 class="mb-3">Job Description</h4>
                        <p class='w-75'>
                            @php
                                echo $Job->job_description;
                            @endphp
                        </p>
                    </div>

                    <hr class="ps-5 ms-4 w-75" />

                    <div class="jobRequirements ps-5">
                        <h4 class="mb-3">Job Requirements</h4>
                        <p class='w-75'>
                            @php
                                echo $Job->job_requirement;
                            @endphp
                        </p>
                    </div>

                    <hr class="ps-5 ms-4 w-75" />
                    <div class="jobBenefits ps-5">
                        <h4 class="mb-3">Benefits</h4>
                        <p class='w-75'>
                            @php
                                echo $Job->benefit;
                            @endphp

                        </p>


                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="jobSummaryCard border rounded-4 shadow-sm overflow-hidden">
                        <div class="COcard-top position-relative d-flex justify-content-center">
                            <div
                                class="COcard-border mx-auto d-flex align-items-center justify-content-center shadow position-absolute top-0 border-2 border-gray bg-primary text-light">
                                <h5>Job Summary</h5>
                            </div>
                        </div>

                        <div class="COcard-body p-3">
                            <ul class="list-unstyled fs-15">
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Published on:</strong>{{ $Job->created_at->format('d-M-Y') }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Vacancy: </strong>{{ $Job->vacancy }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Employment Status: </strong> {{ $Job->work_type_name }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Experience:</strong>{{ $Job->experience_level_name }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Job Category: </strong>{{ $Job->category_name }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Working Industry:</strong>{{ $Job->industry_name }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Gender:</strong>{{ $Job->gender }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Age: </strong>{{ $Job->age }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Job Location:
                                    </strong>{{ $Job->address }},{{ $Job->township_name }},{{ $Job->state_name }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Salary Range:</strong>{{ $Job->salary_range_name }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Salary Period: </strong>{{ $Job->salary_type }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Application Deadline:</strong>{{ $Job->apply_expire_date }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
