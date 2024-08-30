@extends('employer.layouts.master')

@section('title')
    Job Details
@endsection

@section('content')
    <section class="content min-vh-100 mb-3">
        <div class="container">
            <input type="hidden" id="jobId" value="{{ $Job->id }}">
            <div class="job-title-card d-flex justify-content-between bg-white border border-1 rounded-4 shadow-sm p-4" style="margin-top: 20px;">
                <div class="">
                    <h3>{{ $Job->professional_title_name }} | {{ $Job->gender }} - <span>({{ $Job->vacancy }})</span> Posts
                    </h3>
                    <h5 class="company-name mb-3 text-info">{{ $Job->company_name }}</h5>
                    <div class="">
                        <span class="posted-time me-2"><i
                                class="fa-solid fa-clock me-2"></i>{{ $Job->created_at->diffForHumans() }}</span>
                        <span class="view-count"><i class="fa-solid fa-eye me-2"></i>{{ $Job->view_count +1}} Viewer(s)</span>
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
                                    <strong>Published on:</strong>{{ $Job->created_at->format('Y-M-d') }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Vacancy: </strong>{{ $Job->vacancy }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Work Type: </strong> {{ $Job->work_type_name }}
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
                                    <strong>Salary Type: </strong>{{ $Job->salary_type }}
                                </li>
                                <li class="py-3 border-light-subtle border-bottom">
                                    <strong>Application Deadline:</strong>{{ $Job->apply_expire_date }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <h5 class="text-center mt-3 fw-bold mb-4">
                More From <span class="company-name">{{ $Job->company_name }}</span>
            </h5>
            <div class="container">
            <div class="row g-3 mb-4">
                @if(count($moreJobs) != 0)
                @foreach ($moreJobs as $mj)
                    <div class="col-lg-3 mx-auto job-card">
                        <a href="{{ route('employer#headerDetail', [$mj->id, $mj->company_id]) }}"
                            class="text-decoration-none d-inline">
                            <div class="companyJobCard overflow-visible border border-1 rounded p-3 shadow-sm">
                                <div class="row">
                                    <div class="col-4" style="height: 70px;">
                                        <span class="company-logo w-100" style="height: 75px;">
                                            @if ($mj->logo)
                                                <img src="{{ asset('storage/company/' . $mj->logo) }}"
                                                    class="rounded shadow-sm w-100 h-100" alt="" />
                                            @else
                                                <img src="{{asset('image/default_user.jpg')}}" class="rounded shadow-sm w-100 h-100" alt="" />
                                            @endif

                                        </span>
                                    </div>
                                    <div class="col-8">
                                        <div class="company-detail d-flex flex-column justify-content-center align-items-start"
                                            style="height: 100%">
                                            <h6 class="company-job-title text-black">
                                                {{ $mj->professional_title_name }}
                                            </h6>
                                            <h6 class="company-name text-primary">{{ $mj->company_name }}</h6>
                                            <span
                                                class="my-1 fs-13 text-muted">{{ $mj->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                @else
                <div class="my-5">
                    <div class="p-3 bg-secondary text-light text-center rounded-2">
                        <i class="fa-solid fa-triangle-exclamation"></i> No Jobs Found!
                    </div>
                </div>
                @endif


            </div>
            {{$moreJobs->appends(request()->query())->links()}}
        </div>
            <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;" onclick="history.back()">
                    <i class="fa-solid fa-circle-left fs-4"></i>
                </button>
            </div>
        </div>
    </section>
@endsection

@section('scriptcode')
    <script>
        $(document).ready(function() {
            //increasse view count
            $.ajax({
                type: 'get',
                url: '/employer/ajax/viewCount',
                data: {
                    'jobId': $('#jobId').val()
                },
                dataType: 'json',

            })
            // console.log(jobId);
        });
    </script>
@endsection