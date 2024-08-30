@extends('employer.layouts.master')

@section('title')
    Choose Payment Page
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
                            <li class="{{ request()->routeIs('employer#subscribePlan') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
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
                                    <i class="fa-solid me-2 fa-list" style="width: 20px;"></i>
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
                <form action="{{ route('employer#paymentMethod') }}" method="post">
                    @csrf
                    <!-- payment method start -->
                    <div class="card mx-auto mt-3" style="width: 900px;">
                        <div class="card-header bg-primary text-light">
                            <div class="card-title fs-5 fw-bold mt-1">Payment Method</div>
                            <input type="hidden" name="planId" value="{{ $plan->id }}">
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-lg-3 text-center">
                                    <label class="custom-radio">
                                        <input type="radio" name="payment" class="d-none" value="wave">
                                        <div class="radio-btn d-inline-block position-relative text-center"
                                            style="width: 120px; height: 150px;">
                                            <i class="fa-solid fa-check position-absolute bg-primary text-light"></i>
                                            <div class="bank-img position-absolute mt-3">
                                                <img src="{{ asset('image/wavepay.jfif') }}" alt="Wave"
                                                    style="width: 100px;">
                                                <h5 class="text-uppercase text-primary mt-1"
                                                    style="font-size: 12px; font-weight: 400;">Wave Pay</h5>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <label class="custom-radio">
                                        <input type="radio" name="payment" class="d-none" value="kbz">
                                        <div class="radio-btn d-inline-block position-relative text-center"
                                            style="width: 120px; height: 150px;">
                                            <i class="fa-solid fa-check position-absolute bg-primary text-light"></i>
                                            <div class="bank-img position-absolute mt-3">
                                                <img src="{{ asset('image/KBZ.png') }}" alt="KBZ"
                                                    style="width: 100px;">
                                                <h5 class="text-uppercase text-primary mt-1"
                                                    style="font-size: 12px; font-weight: 400;">KBZ Pay</h5>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <label class="custom-radio">
                                        <input type="radio" name="payment" class="d-none" value="aya">
                                        <div class="radio-btn d-inline-block position-relative text-center"
                                            style="width: 120px; height: 150px;">
                                            <i class="fa-solid fa-check position-absolute bg-primary text-light"></i>
                                            <div class="bank-img position-absolute mt-3">
                                                <img src="{{ asset('image/ayapay.jfif') }}" alt="AYA"
                                                    style="width: 100px;">
                                                <h5 class="text-uppercase text-primary mt-1"
                                                    style="font-size: 12px; font-weight: 400;">AYA Pay</h5>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-lg-3 text-center">
                                    <label class="custom-radio">
                                        <input type="radio" name="payment" class="d-none" value="cb">
                                        <div class="radio-btn d-inline-block position-relative text-center"
                                            style="width: 120px; height: 150px;">
                                            <i class="fa-solid fa-check position-absolute bg-primary text-light"></i>
                                            <div class="bank-img position-absolute mt-3">
                                                <img src="{{ asset('image/cbpay.jfif') }}" alt="CB"
                                                    style="width: 100px;">
                                                <h5 class="text-uppercase text-primary mt-1"
                                                    style="font-size: 12px; font-weight: 400;">CB Pay</h5>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- payment method end -->
                    <!-- order summary start -->
                    <div class="row mt-3">
                        <div class="col-lg-12">
                            <div class="card mx-auto" style="width: 900px;">
                                <div class="card-header bg-primary text-light">
                                    <div class="card-title fs-5 fw-bold mt-1">Order Summary</div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group mb-3">
                                        <li class="list-group-item d-flex justify-content-between p-2">
                                            <h6 class="my-0">Balance Amount</h6>
                                            <span class="text-body-secondary">{{ $plan->plan_price }} MMK</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between p-2 border-bottom">
                                            <h6 class="my-0">Charge</h6>
                                            <span class="text-body-secondary">0 MMK</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between p-2">
                                            <strong>Total (MMK)</strong>
                                            <strong>{{ $plan->plan_price }} MMK</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- order summary end -->
                    <div class="mx-auto text-end my-3" style="width: 900px;">

                        <button type="submit" class="jobCreateBtn btn btn-primary text-light">
                            <i class="fa-solid fa-pen-to-square me-2"></i>Choose Payment
                        </button>
                    </div>>
                </form>

                <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                    <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;" onclick="history.back()">
                        <i class="fa-solid fa-circle-left fs-4"></i>
                    </button>
                </div>
            </div>
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
