@extends('employer.layouts.master')

@section('title')
    Profile Update
@endsection

@section('content')
    <div class="container-fluid mb-3">
        <div class="row min-vh-100 min-vw-100">

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
                            <li class="{{ request()->routeIs('employer#profileupdate') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
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
                            <li class="list-group-item p-2 mb-2">
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
                            </li>                            <li class="list-group-item p-2 mb-2">
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
        
            <div class="col-lg-10">

                <form action="{{route('employer#updateImage')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        
                        <div class="col-lg-10">
                            <div class="companyLogoCard border border-1 rounded text-dark bg-light mt-3 shadow-sm">
                        
                                <div class="row m-3 p-3">
                                    <div class="col-lg-3 ">
                                        @if ($image->image == null)
                                            <img src="{{ asset('image/default_user.jpg') }}" alt=""
                                                class="profileLogo rounded" width="150px;">
                                        @else
                                            <img src="{{ asset('storage/company/' . $image->image) }}" alt=""
                                                class="profileLogo rounded" style=" object-fit:cover;">
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
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
                                                    <span class="fw-bold">Select Company Profile</span>
                                                </div>
                                                <input type="file" id="file" name="image"
                                                    value="{{ $image->image }}"
                                                    class="d-none form-control @error('image') is-invalid @enderror" 
                                                >

                                            </label>

                                            <br>
                                            <input type="submit" value="Change" class=" btn btn-info">

                                            <span class="mt-3">Suitable files are jpg,png,tiff & jpeg .</span>
                                            @error('image')
                                                <div class="text-secondary text-center w-100 mt-2 d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                        
                            </div>
                        </div>

                    </div>
                </form>

                <form action="{{ route('employer#updateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="companyLogoCard border border-1 rounded text-dark bg-light mt-3 shadow-sm">

                                <div class="row m-3 p-3">
                                    <div class="col-lg-3 ">
                                        @if ($data->logo == null)
                                            <img src="{{ asset('image/default_user.jpg') }}" alt=""
                                                class="profileLogo rounded">
                                        @else
                                            <img src="{{ asset('storage/company/' . $data->logo) }}" alt=""
                                                class="profileLogo rounded" style=" object-fit:cover;">
                                        @endif
                                    </div>
                                    <div class="col-lg-4 ">

                                        <div class="d-flex flex-column align-items-center justify-content-center"
                                            style="height: 180px;">
                                            <label
                                                class="custum-file-upload d-flex btn btn-primary text-white justify-content-center align-items-center align-content-between"
                                                for="file1">
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
                                                    <span class="fw-bold">Select Company Logo <span class=" text-secondary">*</span></span>
                                                </div>
                                                <input type="file" id="file1" name="companyLogo"
                                                value="{{ $data->logo }}"
                                                class="d-none form-control @error('companyLogo') is-invalid @enderror">
                                            </label>
                                            
                                            <span class="mt-3">Suitable files are jpg,png,tiff & jpeg .</span>

                                            @error('companyLogo')
                                                <div class="text-danger w-100 mt-2">
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
                            <div class="companyBasicInformationCard border border-1 overflow-hidden rounded mt-3 shadow-sm">
                                <div class="card-top d-flex align-item-center justify-content-center">
                                    <div
                                        class="card-header-border shadow d-flex align-items-center justify-content-center  bg-primary text-light">
                                        <h5 class="mb-0">Company Basic Information</h5>
                                    </div>
                                </div>

                                <div class=" my-3">
                                    <div class="row justify-content-evenly">
                                        <div class="col-9 col-lg-5">

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Company Owner <span class=" text-secondary">*</span></label>
                                                <div class="mb-1">
                                                    <input type="text"
                                                        class="form-control @error('companyOwner') is-invalid @enderror"
                                                        placeholder="Enter company ceo name" name="companyOwner"
                                                        value="{{ old('companyOwner', $data->founder_name) }}" />
                                                    @error('companyOwner')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Company Phone <span class=" text-secondary">*</span></label>
                                                <div class="mb-1">
                                                    <input type="number"
                                                        class="form-control @error('companyPhone') is-invalid @enderror"
                                                        id="phone" placeholder="Enter company phone"
                                                        name="companyPhone"
                                                        value="{{ old('companyPhone', $data->company_phone) }}" />
                                                    @error('companyPhone')
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
                                                        placeholder="Enter company address" name="address"
                                                        value="{{ old('address', $data->address) }}" />
                                                    @error('address')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Founded Date</label>

                                                <div class="mb-1">
                                                    <input type="date"
                                                        class="form-control @error('foundedDate') is-invalid @enderror"
                                                        placeholder="Enter founded date" name="foundedDate"
                                                        value="{{ old('foundedDate', $data->founded_date) }}" />
                                                    @error('foundedDate')
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
                                                <label class="mb-1 ms-2 fw-bold">State/Region <span class=" text-secondary">*</span></label>
                                                <div class="mb-1">

                                                    <select class="form-select selectState  @error('state') is-invalid @enderror" id="selectState"
                                                        aria-label="Default select example" name="state">
                                                        <option value="">Select State and Region</option>
                                                        @foreach ($state as $s)
                                                            <option value="{{ $s->id }}"
                                                                @if ($data->state_id == $s->id) selected @endif>
                                                                {{ $s->state_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('state')
                                                        <div class=" invalid-feedback">
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
                                                        <option value="">Choose Township</option>
                                                        <option value="{{ $data->townshipId }}">
                                                            {{ $data->township_name }}</option>
                                                    </select>
                                                    @error('city')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>



                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Social Link</label>

                                                <div class="mb-1">
                                                    <input type="text"
                                                        class="form-control @error('website') is-invalid @enderror"
                                                        placeholder="https://www.website.com" name="website"
                                                        value="{{ old('website', $data->website) }}" />
                                                    @error('website')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>
                                            </div>


                                            <div class="mb-2">
                                                <label class="mb-1 ms-2 fw-bold">Number of Employees</label>

                                                <div class="mb-1">
                                                    <input type="text"
                                                        class="form-control @error('noEmployee') is-invalid @enderror"
                                                        placeholder="Enter Number of employees" name="noEmployee"
                                                        value="{{ old('noEmployee', $data->number_of_employees) }}" />
                                                    @error('noEmployee')
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

                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="companyDescriptionCard border border-1 rounded mt-3 overflow-hidden shadow-sm">
                                <div class="card-top d-flex align-item-center justify-content-center">
                                    <div
                                        class="card-header-border shadow d-flex align-items-center justify-content-center bg-primary text-light">
                                        <h5 class="mb-0">Company Description<span class=" text-secondary">*</span></h5>
                                    </div>
                                </div>

                                <div class=" px-3 py-2">
                                    <textarea type="text" name="companyDescription" class="form-control mx-auto @error('companyDescription') is-invalid @enderror"
                                        style="height: 10em">{{ old('companyDescription', $data->company_description) }}</textarea>
                                    @error('companyDescription')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="my-3 text-end me-5 pe-5">
                        <button type="submit" class="btn btn-outline-primary">Update Profile</button>
                    </div>
                </form>

                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Are You Sure Deactivate Account?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            </div>
            {{-- ------------ --}}
        </div>
    </div>
@endsection

@section('scriptcode')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#checkPurchaseStatus').click(function() {
                $.ajax({
                    url: '{{ route('employer#checkUserStatus') }}',
                    type: 'get',
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

            $('.selectState').change(function() {
                console.log("hello");
                $current = $(this).val();
                console.log($current);
                $.ajax({
                    type: 'get',
                    url: '/employer/ajax/stateData',
                    dataType: 'json',
                    data: {
                        'status': $current
                    },
                    success: function(response) {
                        $('#selectCity').html('');
                        $('#selectCity').append('<option value=" ">Select Township</option>');
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
        @if (session('updateSuccess'))
                    Toast.fire({
                                icon: "success",
                                title: "{{ session('updateSuccess') }}"
                            });

        @endif
        @if (session('dateError'))
                    Toast.fire({
                                icon: "error",
                                title: "{{ session('dateError') }}"
                            });

        @endif
        @if (session('password'))
                    Toast.fire({
                                icon: "error",
                                title: "{{ session('password') }}"
                            });

        @endif
    });
</script>

@endsection
