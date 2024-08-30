@extends('seeker.layouts.master')

@section('title')
    Edit Education
@endsection

@section('content')
    <div class="container-fluid mb-3">
        <div class="row min-vh-100 min-vw-100">

            <!-- sidebar start -->
            <div class="col-lg-2 bg-primary shadow-sm">
                <div class="sidebar p-2">
                    <!-- company name start -->
                    <div class="sidebar-name d-flex align-items-center justify-content-center">
                        <span class=" text-light fs-5 fw-bold mt-3">{{ Auth::user()->name }}</span>
                    </div>
                    <!-- company name end -->
                    <hr class=" text-light">
                    <!-- sidebar list start -->
                    <div class="sidebar-list d-flex align-items-center justify-content-center">
                        <ul class="list-group ps-0 text-start list-unstyled">
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{ route('seeker#home') }}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid me-2 fa-house" style="width: 20px;"></i>
                                    <small>Dashboard</small>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('seeker#editEducation') ? 'sideActive' : ''}} list-group-item p-2 mb-2">

                                <a href="{{ route('seeker#profileupdate') }}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-regular me-2 fa-pen-to-square" style="width: 20px;"></i>
                                    <small>Profile Update</small>
                                </a>
                            </li>
                            
                            
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{route('seeker#recommendJobsPage')}}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid fa-briefcase me-2" style="width: 20px;"></i>
                                    <small>Recommend Job</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{route('seeker#applyJobPage')}}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid fa-keyboard me-2" style="width: 20px;"></i>
                                    <small>Job Applications</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{ route('seeker#saveCompanyPage') }}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid fa-bookmark me-2" style="width: 20px;"></i>
                                    <small>Favourite Company List</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{route('seeker#resume')}}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid fa-file me-2" style="width:20px;"></i>
                                    <small>View Resume</small>
                                </a>
                            </li>
                            <li class=" list-group-item p-2 mb-2">
                                <a href="{{route('seeker#changepasspage')}}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid me-2 fa-lock" style="width: 20px;"></i>
                                    <small>Change Password</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">

                                <a href="" class=" text-decoration-none text-light d-flex align-items-center fs-6"
                                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                    <i class="fa-solid fa-trash me-2" style="width: 20px;"></i>
                                    <small>Deactivate Account</small>
                                </a>

                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-info text-light" id="logout">
                                        <i class="fa-solid me-2 fa-right-from-bracket" style="width: 20px;"></i>
                                        <small>Logout</small>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <!-- sidebar list end -->
                </div>
            </div>
            <!-- sidebar end -->

            <div class="col-lg-10">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="companyBasicInformationCard border border-1 overflow-hidden rounded mt-3 shadow-sm">
                            <div class="card-top d-flex align-item-center justify-content-center">
                                <div
                                    class="card-header-border shadow d-flex align-items-center justify-content-center  bg-primary text-light">
                                    <h5 class="mb-0">Edit Educational Qualification</h5>
                                </div>
                            </div>

                            <div class=" my-3">
                                <form action="{{ route('seeker#updateEducation') }}" method="post">
                                    @csrf
                                    <div class="row justify-content-evenly">
                                        <div class="col-9 col-lg-5">

                                            <input type="hidden" name='EQId' value={{ $educations->id }}>
                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Degree Level</label>
                                                <div class="mb-1">
                                                    <select class="form-select" id=""
                                                        aria-label="Default select example" name="degreeLevel">
                                                        <option>Select Degree Level</option>
                                                        <option value="Accounting"
                                                            @if ($educations->degree_level == 'Accounting') selected @endif>Accounting
                                                        </option>
                                                        <option value="Architecture"
                                                            @if ($educations->degree_level == 'Architecture') selected @endif>Architecture
                                                        </option>
                                                        <option value="Arts"
                                                            @if ($educations->degree_level == 'Arts') selected @endif>Arts</option>
                                                        <option value="Business Administration"
                                                            @if ($educations->degree_level == 'Business Administration') selected @endif>Business
                                                            Administration</option>
                                                        <option value="Business Science"
                                                            @if ($educations->degree_level == 'Business Science') selected @endif>Business
                                                            Science</option>
                                                        <option value="Commerce"
                                                            @if ($educations->degree_level == 'Commerce') selected @endif>Commerce
                                                        </option>
                                                        <option value="Community Health"
                                                            @if ($educations->degree_level == 'Community Health') selected @endif>Community
                                                            Health</option>
                                                        <option value="Computer Science"
                                                            @if ($educations->degree_level == 'Computer Science') selected @endif>Computer
                                                            Science</option>
                                                        <option value="Computer Technology"
                                                            @if ($educations->degree_level == 'Computer Technology') selected @endif>Computer
                                                            Technology</option>
                                                        <option value="Dental Surgery"
                                                            @if ($educations->degree_level == 'Dental Surgery') selected @endif>Dental Surgery
                                                        </option>
                                                        <option value="Economics"
                                                            @if ($educations->degree_level == 'Economics') selected @endif>Economics
                                                        </option>
                                                        <option value="Engineering"
                                                            @if ($educations->degree_level == 'Engineering') selected @endif>Engineering
                                                        </option>
                                                        <option value="Laws"
                                                            @if ($educations->degree_level == 'Laws') selected @endif>Laws
                                                        </option>
                                                        <option value="Medical Technology"
                                                            @if ($educations->degree_level == 'Medical Technology') selected @endif>Medical
                                                            Technology</option>
                                                        <option value="Medicine"
                                                            @if ($educations->degree_level == 'Medicine') selected @endif>Medicine
                                                        </option>
                                                        <option value="Myanmar Traditional Medicine"
                                                            @if ($educations->degree_level == 'Myanmar Traditional Medicine') selected @endif>Myanmar
                                                            Traditional Medicine</option>
                                                        <option value="Nursing Science"
                                                            @if ($educations->degree_level == 'Nursing Science') selected @endif>Nursing
                                                            Science</option>
                                                        <option value="Pharmacy"
                                                            @if ($educations->degree_level == 'Pharmacy') selected @endif>Pharmacy
                                                        </option>
                                                        <option value="Public Administration"
                                                            @if ($educations->degree_level == 'Public Administration') selected @endif>Public
                                                            Administration</option>
                                                        <option value="Science"
                                                            @if ($educations->degree_level == 'Science') selected @endif>Science
                                                        </option>
                                                        <option value="Surgery"
                                                            @if ($educations->degree_level == 'Surgery') selected @endif>Surgery
                                                        </option>
                                                        <option value="Technology"
                                                            @if ($educations->degree_level == 'Technology') selected @endif>Technology
                                                        </option>
                                                        <option value="Others"
                                                            @if ($educations->degree_level == 'Others') selected @endif>Others
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <input type="hidden" name="seekerId" value="{{ Auth::user()->id }}">


                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Area Of Studies</label>
                                                <div class="mb-1">

                                                    <select class="form-select" id=""
                                                        aria-label="Default select example" name="areaOfStudies">
                                                        <option value="">Select Area of Stuides </option>
                                                        <option value="Primary School"
                                                            @if ($educations->area_of_studies == 'Primary School') selected @endif>Primary
                                                            School </option>
                                                        <option value="Middle School"
                                                            @if ($educations->area_of_studies == 'Middle School') selected @endif>Middle
                                                            School</option>
                                                        <option value="High School"
                                                            @if ($educations->area_of_studies == 'High School') selected @endif>High School
                                                        </option>
                                                        <option value="Vocational School"
                                                            @if ($educations->area_of_studies == 'Vocational School') selected @endif>Vocational
                                                            School</option>
                                                        <option value="Diploma Course"
                                                            @if ($educations->area_of_studies == 'Diploma Course') selected @endif>Diploma
                                                            Course</option>
                                                        <option value="Diploma Degree"
                                                            @if ($educations->area_of_studies == 'Diploma Degree') selected @endif>Diploma
                                                            Degree</option>
                                                        <option value="University Course"
                                                            @if ($educations->area_of_studies == 'University Course') selected @endif>University
                                                            Course</option>
                                                        <option value="University Degree"
                                                            @if ($educations->area_of_studies == 'University Degree') selected @endif>University
                                                            Degree</option>
                                                        <option value="Master Level Course"
                                                            @if ($educations->area_of_studies == 'Master Level Course') selected @endif>Master Level
                                                            Course</option>
                                                        <option value="Master Degree"
                                                            @if ($educations->area_of_studies == 'Master Degree') selected @endif>Master
                                                            Degree</option>
                                                        <option value="Doctorate Level Course"
                                                            @if ($educations->area_of_studies == 'Doctorate Level Course') selected @endif>Doctorate
                                                            Level Course</option>
                                                        <option value="Doctorate Degree"
                                                            @if ($educations->area_of_studies == 'Doctorate Degree') selected @endif>Doctorate
                                                            Degree</option>
                                                    </select>

                                                </div>
                                            </div>

                                            <input type="hidden" name="oldEmail" value="{{ Auth::user()->email }}">

                                        </div>

                                        <div class="col-9 col-lg-5">

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Institute Name</label>
                                                <div class="mb-1">
                                                    <input type="text"
                                                        class="form-control @error('institute') is-invalid @enderror"
                                                        placeholder="Enter Institute Name" name="institute"
                                                        value="{{ old('institute', $educations->institute_name) }}" />
                                                    @error('institute')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Passing Year</label>
                                                <div class="mb-1">
                                                    <input type="text"
                                                        class="form-control @error('passingYear') is-invalid @enderror"
                                                        placeholder="Enter Passing Year" name="passingYear"
                                                        value="{{ old('passingYear', $educations->passing_year) }}" />
                                                    @error('passingYear')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="my-3 text-end pe-5">
                                        <button type="submit" class="btn btn-outline-primary">Update</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- account deactivate modal start --}}
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Are You Sure Deactivate Account?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="deleteForm" method="POST" action="{{ route('seeker.delete') }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" value="{{ Auth::user()->email }}"
                                            id="email" name="email" disabled required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control " id="password" name="password"
                                            required>
                                    </div>
                                    <div class="mt-2 text-end">
                                        <button type="button" class="btn btn-info me-2"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" id="delete" class="btn btn-danger">Delete</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- account deactivate modal end --}}




            </div>
            {{-- ------------ --}}
        </div>
        <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
            <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;"
                onclick="history.back()">
                <i class="fa-solid fa-circle-left fs-4"></i>
            </button>
        </div>
    </div>
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
        @if (session('createSuccess'))
            Toast.fire({
                icon: "success",
                title: "{{ session('createSuccess') }}"
            });
        @endif

        @if (session('password'))
            Toast.fire({
                icon: "error",
                title: "{{ session('password') }}"
            });
        @endif
        @if (session('success'))
            Toast.fire({
                icon: "success",
                title: "{{ session('success') }}"
            });
        @endif
    });
</script>
@endsection
