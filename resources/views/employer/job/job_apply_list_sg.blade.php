@extends('employer.layouts.master')

@section('title')
    Single Job Apply List
@endsection

{{-- @dd($jobNature) --}}
{{-- @dd($jobId); --}}
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
                            <li class="{{ request()->routeIs('employer#jobApplySg') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
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
                {{-- job nature start --}}
                <form action="{{ route('employer#searchApplyListSg') }}" method="get">
                    <div class="row mt-3">
                        <div class="col-lg-4">
                            <span><strong>Industry:</strong>&nbsp;{{ $jobNature[0]->industry_name }}</span> <br>
                            <span><strong>Job Position:</strong>&nbsp;{{ $jobNature[0]->professional_title_name }}</span>
                        </div>
                        <div class="col-lg-2 offset-2 text-center mt-1">
                            <h5 class="bg-primary text-light py-1 rounded">Total: &nbsp;{{$data->total()}}</h5>
                        </div>
                        <input type="hidden" name="jobId" value="{{$jobId}}">
                        <div class="col-lg-2">
                            <select name="status" class=" form-select">
                                <option value="">Choose Status</option>
                                <option value="0" @if (request('status') == '0') selected @endif>Pending</option>
                                <option value="1" @if (request('status') == '1') selected @endif>Accept</option>
                                <option value="2" @if (request('status') == '2') selected @endif>Reject</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary">SEARCH</button>
                        </div>
                    </div>
                </form>
                {{-- job nature end --}}

                {{-- job apply list start --}}
                <div class="all-jobs d-flex flex-column align-items-center justify-content-center mt-5">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-active" role="tabpanel"
                            aria-labelledby="pills-active-tab" tabindex="0">
                            <table class="table">
                                <thead class="border-bottom-1">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Professional Title</th>
                                        <th scope="col">State/Region</th>
                                        <th scope="col">Township</th>
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
                                                <td>{{ $d->professional_title_name }}</td>
                                                <td>{{ $d->state_name }}</td>
                                                <td>{{ $d->township_name }}</td>
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
                {{-- job apply list end --}}
                {{ $data->links() }}
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
                    <a href="{{ route('employer#alljob')}}">
                        <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle"
                            style="line-height: 0;">
                            <i class="fa-solid fa-circle-left fs-4"></i>
                        </button>
                    </a>
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
