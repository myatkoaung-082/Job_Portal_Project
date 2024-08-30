@extends('seeker.layouts.master')

@section('title')
    Profile Update
@endsection

@section('content')


    {{-- @dd($data) --}}
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
                            <li class="{{ request()->routeIs('seeker#profileupdate') ? 'sideActive' : ''}} list-group-item p-2 mb-2">

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
                            <li class="list-group-item p-2 mb-2">
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
                <form action="{{ route('seeker#updateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="companyLogoCard shadow-sm border border-1 rounded text-dark bg-light mt-3">

                                <div class="row m-3 p-3">
                                    <div class="col-lg-3 ">
                                        @if ($data->profile_image == null)
                                            <img src="{{ asset('image/default_user.jpg') }}" alt=""
                                                class="profileLogo rounded shadow-sm">
                                        @else
                                            <img src="{{ asset('storage/seeker/' . $data->profile_image) }}" alt=""
                                                class="profileLogo rounded shadow-sm" style="object-fit: cover;">
                                        @endif

                                    </div>
                                    <div class="col-lg-4 ">

                                        <div class="d-flex flex-column align-items-center justify-content-center"
                                            style="height: 180px;">
                                            <label
                                                class="custum-file-upload d-flex btn btn-primary text-white justify-content-center align-items-center align-content-between"
                                                for="file">
                                                <div class="icon me-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill=""
                                                        viewBox="0 0 24 24">
                                                        <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                                        <g stroke-linejoin="round" stroke-linecap="round"
                                                            id="SVGRepo_tracerCarrier"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path fill=""
                                                                d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                                                clip-rule="evenodd" fill-rule="evenodd"></path>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <div class="text">
                                                    <span class="fw-bold">Select Profile Image</span>
                                                </div>
                                                <input type="file" id="file" name="profileImage" value=""
                                                    class="d-none form-control @error('profileImage') is-invalid @enderror">


                                            </label>

                                            <span class="mt-3">Suitable files are jpg,png,tiff & jpeg .</span>

                                            @error('profileImage')
                                                <div class="text-danger w-100 mt-2 d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="companyBasicInformationCard shadow-sm border border-1 overflow-hidden rounded mt-3">
                                <div class="card-top d-flex align-item-center justify-content-center">
                                    <div
                                        class="card-header-border shadow d-flex align-items-center justify-content-center  bg-primary text-light">
                                        <h5 class="mb-0">Basic Information</h5>
                                    </div>
                                </div>

                                <div class=" my-3">
                                    <div class="row justify-content-evenly">
                                        <div class="col-9 col-lg-5">


                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Professional Title <span class=" text-secondary">*</span></label>
                                                <div class="mb-1">

                                                    <select class="form-select  @error('proTitle') is-invalid @enderror" aria-label="Default select example"
                                                        name="proTitle">
                                                        <option value="">Select Professional Title</option>
                                                        @if ($proTitles)
                                                            @foreach ($proTitles as $pt)
                                                                <option value="{{ $pt->id }}"
                                                                    @if ($data->professional_title_id == $pt->id) selected @endif>
                                                                    {{ $pt->professional_title_name }}</option>
                                                            @endforeach
                                                        @else
                                                        @endif


                                                    </select>
                                                    @error('proTitle')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Date of Birth <span class=" text-secondary">*</span></label>

                                                <div class="mb-1">
                                                    <input type="date"
                                                        class="form-control @error('DOB') is-invalid @enderror"
                                                        placeholder="" name="DOB"
                                                        value="{{ old('DOB', $data->dob) }}" />
                                                    @error('DOB')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Martial Status</label>
                                                <div class="mb-1">
                                                    <select
                                                        class="form-select @error('martialStatus') is-invalid @enderror"
                                                        aria-label="Default select example" name="martialStatus">
                                                        <option value="">Select Martial Status</option>
                                                        <option value="Devorced"
                                                            @if ($data->martial_status == 'Devorced') selected @endif>Devorced
                                                        </option>
                                                        <option value="Married"
                                                            @if ($data->martial_status == 'Married') selected @endif>Married
                                                        </option>
                                                        <option value="Separated"
                                                            @if ($data->martial_status == 'Separated') selected @endif>Separated
                                                        </option>
                                                        <option value="Single"
                                                            @if ($data->martial_status == 'Single') selected @endif>Single
                                                        </option>


                                                    </select>
                                                    @error('martialStatus')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Address <span class=" text-secondary">*</span></label>
                                                <div class="mb-1">
                                                    <input type="text"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        placeholder="Enter address" name="address"
                                                        value="{{ old('address', $data->address) }}" />
                                                    @error('address')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Resume</label>

                                                <div class="mb-1">
                                                    <input type="file"
                                                        class="form-control @error('resume') is-invalid @enderror"
                                                        placeholder="" name="resume" value="{{ $data->resume }}" />
                                                    @error('resume')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>
                                            </div>

                                            <input type="hidden" name="oldEmail" value="{{ Auth::user()->email }}">

                                        </div>

                                        <div class="col-9 col-lg-5">

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Phone Number <span class=" text-secondary">*</span></label>
                                                <div class="mb-1">
                                                    <input type="number"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        id="phone" placeholder="Enter phone number" name="phone"
                                                        value="{{ old('phone', $data->phone) }}" />
                                                    @error('phone')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Gender <span class=" text-secondary">*</span></label>
                                                <div class="mb-1">
                                                    <select class="form-select @error('gender') is-invalid @enderror"
                                                        aria-label="Default select example" name="gender">
                                                        <option value="">Select Gender</option>
                                                        <option value="Male"
                                                            @if ($data->gender == 'Male') selected @endif>Male
                                                        </option>
                                                        <option value="Female"
                                                            @if ($data->gender == 'Female') selected @endif>Female
                                                        </option>


                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">State/Region <span class=" text-secondary">*</span></label>

                                                <div class="mb-1">
                                                    <select
                                                        class="form-select selectState @error('state')
                                                    is-invalid
                                                @enderror"
                                                        id="selectState" aria-label="Default select example"
                                                        name="state">
                                                        <option value="">Select State and Region</option>
                                                        @foreach ($states as $s)
                                                            <option value="{{ $s->id }}"
                                                                @if ($data->state_id == $s->id) selected @endif>
                                                                {{ $s->state_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    @error('state')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Township <span class=" text-secondary">*</span></label>

                                                <div class="mb-1">
                                                    <select class="form-select @error('city') is-invalid @enderror"
                                                        aria-label="Default select example" name="city"
                                                        id="selectCity">

                                                        @if ($townships)
                                                            <option value="">Select Township</option>
                                                            @foreach ($townships as $ts)
                                                                <option value="{{ $ts->id }}"
                                                                    @if ($data->city_id == $ts->id) selected @endif>
                                                                    {{ $ts->township_name }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="">Select City</option>
                                                        @endif

                                                    </select>
                                                    @error('city')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="my-3 text-end me-5 pe-5">
                        <button type="submit" class="btn btn-outline-primary me-4" id="updatePF">Update
                            Profile</button>
                    </div>
                </form>

                <div class="">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div
                                class="companyBasicInformationCard shadow-sm border border-1 overflow-hidden rounded mt-3 d-flex flex-column align-items-center">
                                <div class="card-top d-flex align-item-center justify-content-center">
                                    <div class="card-header-border shadow d-flex align-items-center justify-content-center  bg-primary text-light"
                                        style="width:600px">
                                        <h5 class="mb-0">Educational Qualification</h5>
                                    </div>
                                </div>
                                <table class="table m-4" style="width: 850px">
                                    <thead class="border-bottom-1">
                                        <tr>
                                            <th scope="col">Institute Name</th>
                                            <th scope="col">Degree Level</th>
                                            <th scope="col">Area of Studies</th>
                                            <th scope="col">Passing Year</th>
                                            <th scope="col">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($educations) != 0)
                                            @foreach ($educations as $edu)
                                                <tr class="tr-shadow">
                                                    <td>{{ $edu->institute_name }}</td>
                                                    <td>{{ $edu->degree_level }}</td>
                                                    <td>{{ $edu->area_of_studies }}</td>
                                                    <td>{{ $edu->passing_year }}</td>

                                                    <td>

                                                        <a href="{{ route('seeker#editEducation', $edu->id) }}"
                                                            class="btn btn-sm btn-outline-info me-2" data-toggle="tooltip"
                                                            data-placement="top" title="Edit">

                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>
                                                        <a href="{{ route('seeker#deleteEducation', $edu->id) }}"
                                                            class="btn btn-sm btn-outline-danger" data-toggle="tooltip"
                                                            data-placement="top" title="Delete">

                                                            <i class="fa-solid fa-trash"></i>

                                                        </a>


                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center border-bottom-0"> No Data Found</td>
                                            </tr>
                                        @endif




                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>

                    <div class="my-3 text-end me-5 pe-5">
                        <a href="{{ route('add#newEducation') }}" class="btn btn-outline-primary me-4">Add New</a>
                    </div>
                </div>

                <div class="">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div
                                class="companyBasicInformationCard shadow-sm border border-1 overflow-hidden rounded mt-3 d-flex flex-column align-items-center">
                                <div class="card-top d-flex align-item-center justify-content-center">
                                    <div class="card-header-border shadow d-flex align-items-center justify-content-center  bg-primary text-light"
                                        style="width:600px">
                                        <h5 class="mb-0">Employment History</h5>
                                    </div>
                                </div>
                                <table class="table m-4" style="width: 850px">
                                    <thead class="border-bottom-1">
                                        <tr>
                                            <th scope="col">Company Name</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Position</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @if (count($employments) != 0)
                                            @foreach ($employments as $emp)
                                                <tr class="tr-shadow">
                                                    <td>{{ $emp->company_name }}</td>
                                                    <td>{{ $emp->Department }}</td>
                                                    <td>{{ $emp->Position }}</td>
                                                    <td>{{ $emp->Start_Date }}</td>
                                                    <td>{{ $emp->End_Date }}</td>
                                                    <td>
                                                        <a href="{{ route('seeker#editEmployment', $emp->id) }}"
                                                            class="btn btn-sm btn-outline-info me-2" data-toggle="tooltip"
                                                            data-placement="top" title="Edit">

                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>
                                                        <a href="{{ route('seeker#deleteEmployment', $emp->id) }}"
                                                            class="btn btn-sm btn-outline-danger" data-toggle="tooltip"
                                                            data-placement="top" title="Delete">

                                                            <i class="fa-solid fa-trash"></i>

                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center border-bottom-0"> No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>

                    <div class="my-3 text-end me-5 pe-5">
                        <a href="{{ route('add#newEmploymentHistory') }}" class="btn btn-outline-primary me-4">Add
                            New</a>
                    </div>
                </div>

                <div class="">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div
                                class="companyBasicInformationCard shadow-sm border border-1 overflow-hidden rounded mt-3 d-flex flex-column align-items-center">
                                <div class="card-top d-flex align-item-center justify-content-center">
                                    <div class="card-header-border shadow d-flex align-items-center justify-content-center  bg-primary text-light"
                                        style="width:500px">
                                        <h5 class="mb-0">Skill & Language</h5>
                                    </div>
                                </div>
                                <table class="table m-4" style="width: 850px">
                                    <thead class="border-bottom-1">
                                        <tr>
                                            <th scope="col">Skill</th>
                                            <th scope="col">Level</th>
                                            <th scope="col" style="text-align: center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if (count($skills) != 0)
                                            @foreach ($skills as $s)
                                                <tr class="tr-shadow">
                                                    <td>{{ $s->skill_name }}</td>
                                                    <td>{{ $s->skill_level }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('seeker#editSkill', $s->id) }}"
                                                            class="btn btn-sm btn-outline-info me-2" data-toggle="tooltip"
                                                            data-placement="top" title="Edit">
                                                            <i class="fa-regular fa-pen-to-square"></i>
                                                        </a>
                                                        <a href="{{ route('seeker#deleteSkill', $s->id) }}"
                                                            class="btn btn-sm btn-outline-danger" data-toggle="tooltip"
                                                            data-placement="top" title="Delete">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center border-bottom-0"> No Data Found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="my-3 text-end me-5 pe-5">
                        <a href="{{ route('add#newSkillPage') }}" class="btn btn-outline-primary me-4">Add New</a>
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
    </div>
@endsection

@section('scriptcode')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.selectState').change(function() {
                $current = $(this).val();
                $.ajax({
                    type: 'get',
                    url: '/seeker/ajax/stateData',
                    dataType: 'json',
                    data: {
                        'status': $current
                    },
                    success: function(response) {
                        $('#selectCity').html('');
                        $.each(response, function(index, item) {
                            $('#selectCity').append('<option value="' + item
                                .townshipId + '">' + item.township_name +
                                '</option>');
                        });
                    }
                })
            })
        })
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const PFupdateToast = Swal.mixin({
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
            const DeleteToast = Swal.mixin({
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
            const EQAddToast = Swal.mixin({
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
            const EmploymentAddToast = Swal.mixin({
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
            const SkillAddToast = Swal.mixin({
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
            @if (session('updateSuccess'))
                PFupdateToast.fire({
                    icon: "success",
                    title: "{{ session('updateSuccess') }}"
                });
            @endif
            @if (session('deleteSuccess'))
                DeleteToast.fire({
                    icon: "success",
                    title: "{{ session('deleteSuccess') }}"
                });
            @endif
            @if (session('EQAddedSuccess'))
                EQAddToast.fire({
                    icon: "success",
                    title: "{{ session('EQAddedSuccess') }}"
                });
            @endif
            @if (session('EmploymentAddedSuccess'))
                EmploymentAddToast.fire({
                    icon: "success",
                    title: "{{ session('EmploymentAddedSuccess') }}"
                });
            @endif
            @if (session('SkillAddedSuccess'))
                SkillAddToast.fire({
                    icon: "success",
                    title: "{{ session('SkillAddedSuccess') }}"
                });
            @endif
            @if (session('ageError'))
                SkillAddToast.fire({
                    icon: "error",
                    title: "{{ session('ageError') }}"
                });
            @endif

        });
    </script>

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
