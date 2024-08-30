@extends('guest.layouts.main')

@section('title')
    Job Detail
@endsection

@section('content')
    <section class="content min-vh-100 mb-3 mt-4">
        <div class="container">
            <input type="hidden" id="jobId" value="{{ $Job->id }}">
            <div class="job-title-card d-flex justify-content-between bg-white border border-1 rounded-4 shadow-sm p-4">
                <div class="" >
                    <h3 id="jobTitle1">{{ $Job->professional_title_name }} | {{ $Job->gender }} - <span>({{ $Job->vacancy }})</span> Posts
                    </h3>
                    <h5 class="company-name mb-3 text-info" id="jobTitle2">{{ $Job->company_name }}</h5>
                    <div class="" id="jobTitle3">
                        <span class="posted-time me-2"><i
                                class="fa-solid fa-clock me-2"></i>{{ $Job->created_at->diffForHumans() }}</span>
                        <span class="view-count"><i class="fa-solid fa-eye me-2"></i>{{ $Job->view_count +1}} Viewer(s)</span>
                    </div>
                </div>
                <a href="{{ route('seeker#applyJob', [$Job->id, $Job->company_id]) }}" class="btn btn-outline-primary"
                    style="height: fit-content"><i class="fa-solid fa-hand me-2"></i>Apply Now</a>
            </div>
            <div class="row my-3" id="jobdes1">
                <div class="col-lg-9 col-sm-12  mx-sm-auto">
                    <div class="jobDescription p-3">
                        <h4 class="mb-3">Job Description</h4>
                        <p class="">
                            @php
                                echo $Job->job_description;
                            @endphp
                        </p>
                    </div>

                    <hr class="ps-5 ms-4 w-75" />

                    <div class="jobRequirements p-3">
                        <h4 class="mb-3">Job Requirements</h4>
                        <p class='w-75 text-justify'>
                            @php
                                echo $Job->job_requirement;
                            @endphp
                        </p>
                    </div>

                    <hr class="ps-5 ms-4 w-75" />
                    <div class="jobBenefits p-3">
                        <h4 class="mb-3">Benefits</h4>
                        <p class='w-75 text-justify' id="bene">
                            @php
                                echo $Job->benefit;
                            @endphp
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12 mt-sm-2">
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
                        <a href="{{ route('guest#detailJob', [$mj->id, $mj->company_id]) }}"
                            class="text-decoration-none d-inline">
                            <div class="companyJobCard overflow-visible border border-1 rounded p-3 shadow-sm">
                                <div class="row">
                                    <div class="col-4">
                                        <span class="company-logo w-100">
                                            @if ($mj->logo)
                                                <img src="{{ asset('storage/company/' . $mj->logo) }}"
                                                    class="rounded shadow-sm w-100" alt="" />
                                            @else
                                                <img src="{{asset('image/default_user.jpg')}}" class="rounded shadow-sm w-100" alt="" />
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
            <div class="backBtn position-fixed " style="right: 30px;bottom:59px;width:50px;height:50px;">
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
                url: '/seeker/ajax/viewCount',
                data: {
                    'jobId': $('#jobId').val()
                },
                dataType: 'json',

            })
            // console.log(jobId);
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const applySuccessToast = Swal.mixin({
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
        const applyFailToast = Swal.mixin({
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
        @if (session('applySuccess'))
        applySuccessToast.fire({
                                icon: "success",
                                title: "{{ session('applySuccess') }}"
                            });

        @endif
        @if (session('applyFail'))
        applyFailToast.fire({
                                icon: "success",
                                title: "{{ session('applyFail') }}"
                            });

        @endif

       
    });
</script>
@endsection
