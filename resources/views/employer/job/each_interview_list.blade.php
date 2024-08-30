@extends('employer.layouts.master')

@section('title')
    Interview List
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
                            <li class="{{ request()->routeIs('employer#eachInterviewList') ? 'sideActive' : '' }} list-group-item p-2 mb-2">
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
                {{-- job nature start --}}
                <div class="row mt-3">
                    <div class="col-lg-4">
                        <span><strong>Industry:</strong>&nbsp;{{ $jobNature[0]->industry_name }}</span> <br>
                        <span><strong>Job Position:</strong>&nbsp;{{ $jobNature[0]->professional_title_name }}</span>
                    </div>
                    <div class="col-lg-2 offset-5 text-center mt-1">
                        <h5 class="bg-primary text-light py-1 rounded">Total: &nbsp; {{count($data)}}</h5>
                    </div>
                </div>
                {{-- job nature end --}}
                {{-- interview list start --}}
                <div class="row">
                    <div class="col-10 mx-auto mt-3">
                        <div class="interviewList">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Interview Time</th>
                                        <th scope="col">Interview Date</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) != 0)
                                        @foreach ($data as $d)
                                            <tr class="">
                                                <td>{{ $d->seekerName }}</td>
                                                <td>
                                                    <div class="">{{ $d->township_name }}&nbsp;,</div>
                                                    <div class="">{{ $d->state_name }}</div>
                                                </td>
                                                <td>{{ $d->apply_date }}</td>
                                                <td>{{ $d->interview_time }}</td>
                                                <td>{{ $d->interview_date }}</td>
                                                <td>{{ $d->interview_location }}</td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editModal" data-id={{ $d->id }}>
                                                        Send
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editModal" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        Update Interview</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                {{-- {{ route('employer#eachInterviewUpdate', 0)}} --}}
                                                                <form id="editForm" method="post">
                                                                    @csrf
                                                                    {{-- @method('PUT') --}}
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="interviewId"
                                                                            id="interviewId">
                                                                        <div class="input-group flex-nowrap mb-3">
                                                                            <span class="input-group-text"
                                                                                id="addon-wrapping"><i
                                                                                    class="fa-solid fa-clock fs-6 text-primary"></i></span>
                                                                            <input type="text" name="time"
                                                                                class="form-control @error('time') is-invalid @enderror"
                                                                                aria-label="Username"
                                                                                aria-describedby="addon-wrapping">
                                                                        </div>
                                                                        @error('time')
                                                                            <div class=" invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                        <div class="input-group flex-nowrap mb-3">
                                                                            <span class="input-group-text"
                                                                                id="addon-wrapping"><i
                                                                                    class="fa-solid fa-calendar-days fs-6 text-primary"></i></span>
                                                                            <input type="date" name="date"
                                                                                class="form-control @error('date') is-invalid @enderror"
                                                                                aria-label="Username"
                                                                                aria-describedby="addon-wrapping">
                                                                        </div>
                                                                        @error('date')
                                                                            <div class=" invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                        <div class="input-group flex-nowrap mb-3">
                                                                            <span class="input-group-text"
                                                                                id="addon-wrapping"><i
                                                                                    class="fa-solid fa-location-dot fs-6 text-primary"></i></span>
                                                                            <input type="text" name="location"
                                                                                class="form-control @error('location') is-invalid @enderror"
                                                                                aria-label="Username"
                                                                                aria-describedby="addon-wrapping">
                                                                        </div>
                                                                        @error('location')
                                                                            <div class=" invalid-feedback">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save
                                                                            changes</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
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

                            <div class="mt-3 ">
                                {{ $data->links()}}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- intrview list end --}}
                {{-- interview modal start --}}
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmDeleteModalLabel">Are U Sure DeactivateAccount?</h5>
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
                {{-- interview modal end --}}
                <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                    <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle"
                        style="line-height: 0;" onclick="history.back()">
                        <i class="fa-solid fa-circle-left fs-4"></i>
                    </button>
                </div>
            </div>
            <!-- main content end -->
        </div>
    </div>
    {{-- </div> --}}
@endsection

@section('scriptcode')
    {{-- interview update --}}
    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                // console.log(id);
                var modal = $(this);
                modal.find('.modal-body #interviewId').val(id);
                var formAction = '/employer/job/eachInterviewUpdate/' + id;
                modal.find('#editForm').attr('action', formAction);
            });
        })
    </script>

    {{-- interview alert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
            // Check for success messages
            @if (session('updateSuccess'))
                toast.fire({
                    icon: "success",
                    title: "{{ session('updateSuccess') }}"
                });
            @endif
        });
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
@endsection
