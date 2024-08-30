@extends('employer.layouts.master')

@section('title')
    All Jobs
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
                            <li class="{{ request()->routeIs('employer#alljob') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
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
            <div class="col-lg-10 ">
                <div class="all-jobs d-flex flex-column align-items-center justify-content-center mt-5">
                    <ul class="nav nav-pills rounded border border-1 mb-3" id="pills-tab" role="tablist"
                        style="width: 803px">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark active" id="pills-active-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active"
                                aria-selected="true">Active Jobs</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="pills-expired-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-expired" type="button" role="tab" aria-controls="pills-expired"
                                aria-selected="false">Expired Jobs</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        {{-- active job start --}}
                        <div class="tab-pane fade show active" id="pills-active" role="tabpanel"
                            aria-labelledby="pills-active-tab" tabindex="0">
                            <table class="table">
                                <thead class="border-bottom-1">
                                    <tr>
                                        <th scope="col">Industry</th>
                                        <th scope="col">Job Position</th>
                                        <th scope="col">Posted Date</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Interviews</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($activeJob) != 0)
                                        @foreach ($activeJob as $aj)
                                            <tr class=" tr-shadow">
                                                <td>{{ $aj->industry_name }}</td>
                                                <td>{{ $aj->professional_title_name }}</td>
                                                <td>{{ $aj->created_at->format('Y-m-d') }}</td>
                                                <td class="text-center">{{ $aj->total_job }}</td>
                                                <td class="text-center">{{ $aj->total_interview }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('employer#jobApplySg', $aj->id) }}"
                                                        class="btn btn-outline-primary btn-sm me-2" data-toggle="tooltip"
                                                        data-placement="top" title="Applicant List">
                                                        <i class="fa-solid fa-users-line fs-6"></i>
                                                    </a>
                                                    <a href="{{ route('employer#eachInterviewList', $aj->id) }}"
                                                        class="btn btn-outline-primary btn-sm me-2" data-toggle="tooltip"
                                                        data-placement="top" title="Interview List">
                                                        <i class="fa-solid fa-user-tie fs-6"></i>
                                                    </a>
                                                    <a href="{{ route('employer#editJob', $aj->id) }}"
                                                        class="btn btn-outline-info btn-sm me-2" data-toggle="tooltip"
                                                        data-placement="top" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square fs-6"></i>
                                                    </a>
                                                    <form id="delete-form" action="" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <!-- Delete button -->
                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="tooltip"
                                                        data-placement="top" title="Delete"
                                                        onclick="confirmDelete('{{ route('employer#deleteJob', $aj->id) }}')"><i class="fa-solid fa-trash fs-6"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else()
                                        <tr>
                                            <td colspan="6" class="text-center border-bottom-0"> No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        {{-- active job end --}}
                        {{-- expire job start --}}
                        <div class="tab-pane fade" id="pills-expired" role="tabpanel"
                            aria-labelledby="pills-expired-tab" tabindex="0">
                            <table class="table">
                                <thead class="border-bottom-1">
                                    <tr>
                                        <th scope="col">Industry</th>
                                        <th scope="col">Job Position</th>
                                        <th scope="col">Posted Date</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Interviews</th>
                                        <th scope="col">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($expireJob) != 0)
                                        @foreach ($expireJob as $ej) 
                                            <tr class="tr-shadow">
                                                <td>{{ $ej->industry_name }}</td>
                                                <td>{{ $ej->professional_title_name }}</td>
                                                <td>{{ $ej->created_at->format('Y-m-d') }}</td>
                                                <td class="text-center">{{ $ej->total_job }}</td>
                                                <td class="text-center">{{ $ej->total_interview }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('employer#jobApplySg', $ej->id) }}"
                                                        class="btn btn-sm btn-outline-primary me-2" data-toggle="tooltip"
                                                        data-placement="top" title="Apply List">
                                                        <i class="fa-solid fa-users-line fs-6"></i>
                                                    </a>
                                                    <a href="{{ route('employer#eachInterviewList', $ej->id) }}"
                                                        class="btn btn-sm btn-outline-primary me-2" data-toggle="tooltip"
                                                        data-placement="top" title="Apply List">
                                                        <i class="fa-solid fa-user-tie fs-6"></i>
                                                    </a>
                                                    <a href="{{ route('employer#editJob', $ej->id) }}"
                                                        class="btn btn-sm btn-outline-info me-2" data-toggle="tooltip"
                                                        data-placement="top" title="Edit">
                                                        <i class="fa-solid fa-pen-to-square fs-6"></i>
                                                    </a>
                                                    <form id="delete-form" action="" method="POST"
                                                        style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <!-- Delete button -->
                                                    <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip"
                                                        data-placement="top" title="Delete"
                                                        onclick="confirmDelete('{{ route('employer#deleteJob', $ej->id) }}')"><i class="fa-solid fa-trash fs-6"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else()
                                        <tr>
                                            <td colspan="6" class="text-center border-bottom-0"> No Data Found</td>
                                        </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>
                        {{-- expire job end --}}
                    </div>
                </div>

                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Are You Sure Deactivate Account?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
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
            </div>
            <!-- main content end -->
        </div>
    </div>
@endsection

@section('scriptcode')
    <script>
        $(document).ready(function() {
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
        function confirmDelete(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the action of the hidden form to the URL
                    const form = document.getElementById('delete-form');
                    form.action = url;

                    // Submit the form
                    form.submit();
                }
            });
        }




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
            // const jobDeleteToast = Swal.mixin({
            //     toast: true,
            //     position: "top-end",
            //     showConfirmButton: false,
            //     timer: 3000,
            //     timerProgressBar: true,
            //     didOpen: (toast) => {
            //         toast.onmouseenter = Swal.stopTimer;
            //         toast.onmouseleave = Swal.resumeTimer;
            //     }
            // });
            // Check for success messages
            @if (session('updateSuccess'))
                Toast.fire({
                    icon: "success",
                    title: "{{ session('updateSuccess') }}"
                });
            @endif

            @if (session('deleteJob'))
                Toast.fire({
                    icon: "success",
                    title: "{{ session('deleteJob') }}"
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
