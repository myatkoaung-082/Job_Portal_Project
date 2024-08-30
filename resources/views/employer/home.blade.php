@extends('employer.layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class=" container-fluid">
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
                            <li class="{{ request()->routeIs('employer#home') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
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

                <div class="col-lg-10 mb-5">
                    <!-- view list start -->
                    <div class="view-list">
                        <div class="row mt-3 p-5">
                            <!-- all job start -->
                            <div class="col-lg-4 ">
                                <div class="card mx-auto shadow" style="width: 238px;">
                                    <div class="card-body d-flex flex-row align-items-center justify-content-around">
                                        <div class="card-icon">
                                            <i class="fa-solid fa-briefcase fs-2 text-primary"></i>
                                        </div>
                                        <div class="card-content text-primary">
                                            <h5 class="card-title">
                                                @if (isset($activeJob))
                                                {{count($activeJob)}}+
                                                @else
                                                0+
                                                @endif
                                            </h5>
                                            <p class="card-text">All Jobs</p>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-primary text-center">
                                        <a href="{{route('employer#alljob')}}" class="btn btn-light text-dark my-1  shadow-sm">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- all job end -->
                            <!-- apply list start -->
                            <div class="col-lg-4 ">
                                <div class="card mx-auto shadow" style="width: 238px;">
                                    <div class="card-body d-flex flex-row align-items-center justify-content-around">
                                        <div class="card-icon">
                                            <i class="fa-solid fa-laptop fs-2 text-primary"></i>
                                        </div>
                                        <div class="card-content text-primary">
                                            <h5 class="card-title">
                                                @if (isset($applyTotal))
                                                    {{ count($applyTotal) }}+
                                                @else
                                                    0+
                                                @endif
                                            </h5>
                                            <p class="card-text">Apply List</p>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-primary text-center">
                                        <a href="{{ route('employer#jobApply')}}" class="btn btn-light text-dark my-1  shadow-sm">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- apply list end -->
                            <!-- interview list start -->
                            <div class="col-lg-4 ">
                                <div class="card mx-auto shadow" style="width: 238px;">
                                    <div class="card-body d-flex flex-row align-items-center justify-content-around">
                                        <div class="card-icon">
                                            <i class="fa-solid fa-user-tie fs-2 text-primary"></i>
                                        </div>
                                        <div class="card-content text-primary">
                                            <h5 class="card-title">
                                                @if (isset($interviewTotal))
                                                    {{ count($interviewTotal) }}+
                                                @else
                                                    0+
                                                @endif
                                            </h5>
                                            <p class="card-text">Interview List</p>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-primary text-center">
                                        <a href="{{ route('employer#interviewList') }}" class="btn btn-light text-dark my-1  shadow-sm">View All</a>
                                    </div>
                                </div>
                            </div>
                            <!-- interview list end -->
                        </div>
                    </div>

                    <div class="plan-list">
                        <div class="row">
                            <div class="plan-title bg-warning text-center">
                                <h5 class="p-2 fw-bold text-capitalize">Boost your hiring power with our exclusive job posting Plans!</h5>
                                <p class="px-5">
                                    Our tailored job posting plans are designed to maximize your reach and streamline your hiring process. <br> Whether you’re a startup, a growing business, or an established company, we have the perfect plan to fit your needs! </p>
                            </div>
                            <!-- basic plan start -->
                            @foreach ($data as $p)
                                <div class="col-6 mt-5">
                                    <div class="card mx-auto shadow-sm" style="width: 350px;">
                                        <div class="card-body">
                                            <div class="plan-title d-flex flex-column align-items-center py-3">
                                                <h5>{{ $p->plan_name }}</h5>
                                                <div class="plan-price">
                                                    <span>Kyats</span>
                                                    <span class="fw-bold">{{ $p->plan_price }}</span>
                                                    <span>/Month</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="plan-details">
                                                <h6>Features</h6>
                                                <ul class="list-group">
                                                    <li class="list-group-item">Ability to Post Daily Job Listings</li>
                                                    <li class="list-group-item">Display Company Logo on Seeker Home Page</li>
                                                    <li class="list-group-item">Custom Filtering & Selection of Job Seekers</li>
                                                    <li class="list-group-item">Schedule Interview for Job Seekers</li>                                              </ul>
                                            </div>
                                            <a href="{{ route('employer#subscribePlan', $p->id) }}"
                                                class="btn btn-primary shadow-sm d-flex justify-content-center">Subscribe</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- basic plan end -->
                        </div>
                    </div>
                    <!-- plan list end -->
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
    <script>
        // for create job 
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

        // for deactivate account
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
        });
    </script>
@endsection
