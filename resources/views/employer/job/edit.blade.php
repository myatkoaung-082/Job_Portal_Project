@extends('employer.layouts.master')

@section('title')
    Edit Jobs
@endsection

@section('content')
    <div class=" container-fluid">
        <div class="row min-vh-100 min-vw-100 mb-2">

            <!-- sidebar start -->
            <div class="col-lg-2 bg-primary shadow-sm">
                <div class="sidebar p-2">
                     <!-- company name start -->
                     <div class="sidebar-name d-flex flex-column align-items-center justify-content-center">
                        <span class=" text-light fs-5 fw-bold mt-3">
                            @if(isset($image))
                                @if ($image->image == null)
                                    <img src="{{ asset('image/default_user.jpg') }}" alt=""
                                        class="profileLogo rounded-circle" width="50px" height="50px">
                                @else
                                    <img src="{{ asset('storage/company/' . $image->image) }}" alt=""
                                        class="profileLogo rounded" style=" object-fit:cover;" width="50px" height="50px">
                                @endif
                            @endif
                        </span>
                        <div class=" text-light fs-5 fw-bold mt-1 text-center">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                    <!-- company name end -->
                    <hr class=" text-light">
                    <!-- sidebar list start -->
                    <div class="sidebar-list d-flex align-items-center justify-content-center">
                        <ul class="list-group ps-0 text-start list-unstyled">
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{ route('employer#home') }}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid me-2 fa-house" style="width: 20px;"></i>
                                    <small>Dashboard</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{ route('employer#profileupdate') }}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-regular me-2 fa-pen-to-square" style="width: 20px;"></i>
                                    <small>Profile</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <a href="#" class=" text-decoration-none text-light d-flex align-items-center fs-6"
                                    id="checkPurchaseStatus">
                                    <i class="fa-regular me-2 fa-square-plus" style="width: 20px;"></i>
                                    <small>Create Job</small>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('employer#editJob') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
                                <a href="{{ route('employer#alljob') }}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid me-2 fa-list" style="width: 20px;"></i>
                                    <small>All Jobs</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{ route('employer#IndustryPage') }}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid fa-industry me-2" style="width: 20px;"></i>
                                    <small>Industry</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{ route('employer#transactionPage') }}"
                                    class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                    <i class="fa-solid me-2 fa-money-check-dollar" style="width: 20px;"></i>
                                    <small>Transaction History</small>
                                </a>
                            </li>
                            <li class="list-group-item p-2 mb-2">
                                <a href="{{ route('employer#changepasspage') }}"
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
                                    <button type="submit" class="btn btn-info text-light">
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

            <!-- main content start -->

            <div class="col-lg-10">
                <form action="{{ route('employer#updateJob') }}" method="post">
                    @csrf
                    <!-- job basic info start -->
                    <div class="companyBasicInformationCard mt-3 mx-auto rounded shadow-sm" style="width: 960px;">
                        <div class="CBIcard-top">
                            <div class="CBIcard-border bg-primary text-light">
                                <h5>Job Basic Infromation</h5>
                            </div>
                        </div>

                        <input type="hidden" name="JobID" value="{{$Job->id}}">
                        <div class="card-body px-5 py-2">
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Category</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>

                                        <select name="category" class="input category @error('category') is-invalid @enderror">
                                            @foreach ($categories as $c )

                                                    <option value="{{ $c->id }}" @if($Job->category_id == $c->id)selected @endif>
                                                            {{$c->name}}
                                                    </option>

                                            @endforeach
                                        </select>
                                        @error('category')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Job Position</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <select name="profession" class="input @error('profession') is-invalid @enderror" id="profession">
                                            <option value="{{$Job->professional_title_id}}">{{$Job->professional_title_name}}</option>
                                        </select>
                                        @error('profession')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Industry</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <select name="industry" class="input @error('industry') is-invalid @enderror">
                                            <option value="">Select Industry</option>
                                            @if ($industry)
                                                @foreach ($industry as $ind)
                                                    <option value="{{ $ind->id }}" @if($Job->company_industry_id == $ind->id) selected @endif>{{ $ind->industry_name }}</option>
                                                @endforeach
                                            @else
                                            @endif
                                        </select>
                                        @error('industry')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Work Type</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <select name="worktype" class="input @error('worktype') is-invalid @enderror">
                                            <option value="">Select Work Type</option>
                                            @if ($workType)
                                                @foreach ($workType as $wt)
                                                    <option value="{{ $wt->id }}" @if($Job->work_type_id == $wt->id)selected @endif>{{ $wt->work_type_name }}</option>
                                                @endforeach
                                            @else
                                            @endif
                                        </select>
                                        @error('worktype')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Salary Type</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <input type="text" name="salarytype" value="{{ old('salarytype', $Job->salary_type) }}" class="input @error('salarytype') is-invalid @enderror" id="" list="salaryType">
                                        <datalist id='salaryType'>
                                            <option>Hourly Salary</option>
                                            <option>Weekly Salary</option>
                                            <option>Monthly Salary</option>
                                            <option>Salary by Project</option>
                                        </datalist>
                                        @error('salarytype')
                                        <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Salary Range</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <select name="salaryrange" class="input @error('salaryrange') is-invalid @enderror">
                                            <option value="">Select Salary Range</option>
                                            @if ($salaryRange)
                                                @foreach ($salaryRange as $sr)
                                                    <option value="{{ $sr->id }}" @if($Job->salary_range_id == $sr->id)selected @endif>{{ $sr->salary_range_name }}</option>
                                                @endforeach
                                            @else
                                            @endif
                                        </select>
                                        @error('salaryrange')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Experience Level</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <select name="experience" class="input @error('experience') is-invalid @enderror">
                                            <option value="">Select Experience Level</option>
                                            @if ($experienceLevel)
                                                @foreach ($experienceLevel as $el)
                                                    <option value="{{ $el->id }}" @if($Job->experience_level_id == $el->id)selected @endif>{{ $el->experience_level_name }}</option>
                                                @endforeach
                                            @else
                                            @endif
                                        </select>
                                        @error('experience')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Job Apply Expired Date</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <input type="date" name="expdate" class="input @error('expdate') is-invalid @enderror" value="{{ old('expdate', $Job->apply_expire_date) }}">
                                        @error('expdate')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Gender</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <input type="text" name="gender" value="{{ old('gender', $Job->gender) }}" class="input @error('gender') is-invalid @enderror" id="" list="gender">
                                        <datalist id='gender'>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>M/F</option>
                                        </datalist>
                                        @error('gender')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Vacancy</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <input type="number" name="vacancy" class="input @error('vacancy') is-invalid @enderror" value="{{ old('vacancy', $Job->vacancy) }}">
                                        @error('vacancy')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <label for="" class="form-label">Age</label>
                                    <div class="input-form">
                                        <i class="fa-solid fa-list"></i>
                                        <input type="text" name="age" class="input @error('age') is-invalid @enderror" value="{{ old('age', $Job->age) }}">
                                        @error('age')
                                            <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- job basic info end -->

                    <!-- job description start -->
                    <div class="companyBasicInformationCard mt-3 mx-auto rounded shadow-sm" style="width: 960px;">
                        <div class="CBIcard-top">
                            <div class="CBIcard-border bg-primary text-light">
                                <h5>Job Description</h5>
                            </div>
                        </div>
                        <div class="card-body px-3 pb-2">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <textarea type="text" name="jobDescription" class="form-control @error('jobDescription') is-invalid @enderror" style="height: 10em;">{{ old('jobDescription', $Job->job_description) }}</textarea>
                                    @error('jobDescription')
                                        <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- job description end -->
                    <!-- job requirements start -->
                    <div class="companyBasicInformationCard mt-3 mx-auto rounded shadow-sm" style="width: 960px;">
                        <div class="CBIcard-top">
                            <div class="CBIcard-border bg-primary text-light">
                                <h5>Job Requirements</h5>
                            </div>
                        </div>
                        <div class="card-body px-3 pb-2">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <textarea type="text" name="jobRequirement" class="form-control @error('jobRequirement') is-invalid @enderror" style="height: 10em;">{{ old('jobRequirement', $Job->job_requirement) }}</textarea>
                                    @error('jobRequirement')
                                        <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- job requirements end -->
                    <!-- job benefits start -->
                    <div class="companyBasicInformationCard mt-3 mx-auto rounded shadow-sm" style="width: 960px;">
                        <div class="CBIcard-top">
                            <div class="CBIcard-border bg-primary text-light">
                                <h5>Job Benefits</h5>
                            </div>
                        </div>
                        <div class="card-body px-3 pb-2">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <textarea type="text" name="jobBenefit" class="form-control @error('jobBenefit') is-invalid @enderror" style="height: 10em;">{{ old('jobBenefit', $Job->benefit) }}</textarea>
                                    @error('jobBenefit')
                                        <span class="text-secondary invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- job benefits end -->
                    <div class="mx-auto text-end my-3" style="width: 960px;">
                        <button type="submit" class="jobCreateBtn btn btn-primary text-light">
                            <i class="fa-solid fa-pen-to-square me-2"></i>Update
                        </button>
                    </div>
                </form>

                <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                    <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;" onclick="history.back()">
                        <i class="fa-solid fa-circle-left fs-4"></i>
                    </button>
                </div>
            </div>

            {{-- deactivate modal start --}}
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">

                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Are You Sure Deactivate Account?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                        </div>
                        <div class="modal-body">
                            <form id="deleteForm" method="POST" action="{{ route('companys.delete') }}">
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
            {{-- deactivate modal end --}}
            <!-- main content end -->
        </div>
    </div>
@endsection

@section('scriptcode')
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);

        $(document).ready(function() {
            $('.category').change(function() {
                $current = $(this).val();
                console.log($current);
                $.ajax({
                    type: 'get',
                    url: '/employer/ajax/categorydata',
                    dataType: 'json',
                    data: {
                        'status': $current
                    },
                    success: function(response) {
                        console.log(response);
                        $('#profession').html('');
                        $.each(response, function(index, item) {
                            $('#profession').append('<option value="' + item
                                .profession + '">' + item.profession_name +
                                '</option>');
                        });
                    }
                })
            })


            $('#checkPurchaseStatus').click(function() {
                $.ajax({
                    url: '{{ route('employer#checkUserStatus') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.status == 1) {
                            window.location.href =
                                '{{ url('employer/createPage') }}'; // Adjust URL as needed
                        } else {
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
                            Toast.fire({
                                icon: "warning",
                                title: "You need to subscribe plan"
                            });
                        }

                    }

                });
            })


        })
    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
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
        @if (session('updatefail'))
                    Toast.fire({
                                icon: "warning",
                                title: "{{ session('updatefail') }}"
                            });

        @endif
    });
</script>
@endsection
