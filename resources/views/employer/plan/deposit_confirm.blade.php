@extends('employer.layouts.master')

@section('title')
    Deposite Confirm Page
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
                            @if (isset($image))
                                @if ($image->image == null)
                                    <img src="{{ asset('image/default_user.jpg') }}" alt=""
                                        class="profileLogo rounded-circle" width="50px" height="50px">
                                @else
                                    <img src="{{ asset('storage/company/' . $image->image) }}" alt=""
                                        class="profileLogo rounded" style=" object-fit:cover;" width="50px"
                                        height="50px">
                                @endif
                            @endif
                        </span>
                        <div class=" text-light fs-5 fw-bold mt-1">
                            {{ Auth::user()->name }}
                        </div>
                    </div>
                    <!-- company name end -->
                    <hr class=" text-light">
                    <!-- sidebar list start -->
                    <div class="sidebar-list d-flex align-items-center justify-content-center">
                        <ul class="list-group ps-0 text-start list-unstyled">
                            <li
                                class="{{ request()->routeIs('employer#paymentMethod') ? 'sideActive' : '' }} list-group-item p-2 mb-2">
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
                <form action="{{ route('employer#depositConfirm') }}" method="POST" enctype="multipart/form-data"
                    class="mb-3">
                    @csrf
                    <div class="card mt-3 mx-auto" style="width: 600px;">
                        <div class="card-header bg-primary text-light">
                            <div class="card-title fs-5 fw-bold mt-1">Deposit Confirmation</div>
                        </div>
                        <div class="card-body">
                            <!-- instruction start -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="instruction-title border-bottom text-center py-3">
                                        <h5 class="text-capitalize fw-bold">please follow the instruction below</h5>
                                        <span class="text-muted">Transfer your charges to</span>
                                    </div>
                                    <div class="instruction-account border-bottom d-flex flex-column text-center py-3">
                                        @if ($data == 'wave')
                                            <span class="fw-medium">Wave Pay</span>
                                            <span class="fw-medium">Ko Zayar Tun</span>
                                            <span class="fw-medium">09-779902595</span>
                                        @elseif ($data == 'kbz')
                                            <span class="fw-medium">KBZ Pay</span>
                                            <span class="fw-medium">Ko Zayar Tun</span>
                                            <span class="fw-medium">09-779902595</span>
                                        @elseif ($data == 'aya')
                                            <span class="fw-medium">AYA Pay</span>
                                            <span class="fw-medium">Ko Zayar Tun</span>
                                            <span class="fw-medium">09-779902595</span>
                                        @elseif ($data == 'cb')
                                            <span class="fw-medium">CB Pay</span>
                                            <span class="fw-medium">Ko Zayar Tun</span>
                                            <span class="fw-medium">09-779902595</span>
                                        @endif
                                    </div>
                                    <div class="instruction-footer text-center py-3">
                                        After successfully transfer, please take screenshot paid slip. <br> Providing with
                                        Transaction No.
                                    </div>
                                </div>
                            </div>
                            <!-- instruction end -->
                            <!-- transaction info start -->
                            <div class="row">
                                <div class="col-lg-6 border rounded-2 my-3 p-3 mx-auto shadow-sm">
                                    <input type="hidden" name="companyId" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="planId" value="{{ $planId }}">
                                    <div class="inputs">
                                        <label for="" class="form-label fw-medium">Account Name</label>
                                        <div class="input-form">
                                            <i class="fa-solid fa-user"></i>
                                            <input type="text" name="accountName" value="{{ old('accountName') }}"
                                                class="input @error('accountName') is-invalid @enderror" required>
                                        </div>
                                        <div class="my-2">
                                            @error('accountName')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="inputs mt-3">
                                        <label for="" class="form-label fw-medium">Account Phone</label>
                                        <div class="input-form">
                                            <i class="fa-solid fa-phone"></i>
                                            <input type="number" name="accountPhone"
                                                value="{{ old('accountPhone') }}"class="input @error('accountPhone') is-invalid @enderror"
                                                required>
                                        </div>
                                        <div class="my-2">
                                            @error('accountPhone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="inputs mt-3">

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
                                                <span class="fw-bold">Select Transaction Slip</span>
                                            </div>
                                            <input type="file" name="transactionSlip" id="file"
                                                class="d-none form-control @error('transactionSlip') is-invalid @enderror"
                                                required>
                                        </label>

                                        <div class="my-2">
                                            @error('transactionSlip')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="w-100 text-end mt-3" style="">
                                        <button type="submit" class="btn btn-outline-primary shadow-sm px-3 py-2">
                                            <i class="fa-solid fa-hand-holding-dollar me-2"></i> Deposit Confirm
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- transaction info end -->
                        </div>
                    </div>
                </form>
                <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                    <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle"
                        style="line-height: 0;" onclick="history.back()">
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
    {{-- check plan --}}
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
    {{-- deactivate account --}}
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
        });
    </script>
@endsection
