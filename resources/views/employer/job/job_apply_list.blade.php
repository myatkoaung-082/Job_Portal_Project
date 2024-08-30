@extends('employer.layouts.master')

@section('title')
    Job Apply List
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
                            <li class="{{ request()->routeIs('employer#jobApply') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
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
            <div class="col-lg-10 mx-auto">

                {{-- search section start --}}
                <form action="{{ route('employer#searchApplyList', ) }}" method="get" class="wow animate__fadeInDown">
                    @csrf
                    <div class="row d-flex align-items-center mt-3 ms-auto">
                        <div class=" col-lg-3">
                            <div class="input-form">
                                <i class="fa-solid fa-keyboard text-primary fs-6"></i>
                                <input type="text" name="searchKey" class="input" placeholder="Enter Seeker Name"
                                    value="{{ request('searchKey') }}">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit"
                                class="btn btn-primary text-light input-form w-100 d-flex align-items-center justify-content-center"><i
                                    class="fa-solid fa-magnifying-glass me-2"></i>SEARCH</button>
                        </div>
                    </div>
                </form>
                {{-- search section end --}}

                {{-- apply list start --}}
                <div class="all-jobs d-flex flex-column align-items-center justify-content-center mt-5">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-active" role="tabpanel"
                            aria-labelledby="pills-active-tab" tabindex="0">
                            <table class="table">
                                <thead class="border-bottom-1">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Industry</th>
                                        <th scope="col">Job Position</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) != 0)
                                        @foreach ($data as $d)
                                            <tr class="{{ in_array($d->id, $highlight) ? 'table-info' : '' }}">
                                                <input type="hidden" class="jobApplyId" value="{{ $d->id }}">
                                                <td>{{ $d->seekerName }}</td>
                                                <td>{{ $d->industry_name }}</td>
                                                <td>{{ $d->professional_title_name }}</td>
                                                <td>
                                                    <div class="">{{ $d->state_name }},</div>
                                                    <div class="">{{ $d->township_name }}</div>
                                                </td>
                                                <td>{{ $d->apply_date }}</td>
                                                <td>
                                                    <select name="status" class=" form-select statusChange">
                                                        <option value="0"
                                                            @if ($d->status == 0) selected @endif>Pending
                                                        </option>
                                                        <option value="1"
                                                            @if ($d->status == 1) selected @endif>Accept
                                                        </option>
                                                        <option value="2"
                                                            @if ($d->status == 2) selected @endif>Reject
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="{{ route('employer#applyDetials', $d->seeker_id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </a>
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


                    </div>
                </div>
                {{ $data->appends(request()->query())->links() }}
                {{-- apply list end --}}

                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-4 offset-7">
                        <div class="card">
                            <div class="card-body">
                                <span>
                                    <i class="fa-solid fa-square-full text-info fs-6 me-2"></i>
                                    <small>Applied to multiple jobs in the same company</small>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- back button start --}}
                <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                    <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;"
                        onclick="history.back()">
                        <i class="fa-solid fa-circle-left fs-4"></i>
                    </button>
                </div>
                {{-- back button end --}}
            </div>
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
            <!-- main content end -->
        </div>
    </div>
@endsection

@section('scriptcode')
    <script>
        $('.statusChange').change(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to proceed?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, proceed with the action
                    $currentStatus = $(this).val();
                    // console.log($current);
                    $parentNode = $(this).parents("tr");
                    $jobApplyId = $parentNode.find('.jobApplyId').val();
                    // console.log($jobApplyId);
                    $data = {
                        'status': $currentStatus,
                        'jobApplyId': $jobApplyId
                    };

                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/employer/ajax/statusChange',
                        data: $data,
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response.message);
                            const toast = Swal.mixin({
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
                            toast.fire({
                                icon: "success",
                                title: response.message
                            });
                            setInterval(() => {
                                window.location.reload();
                            }, 3000);
                        }
                    })
                } else {
                    // User canceled, reset the selection
                    window.location.reload();
                }
            });
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
@endsection
