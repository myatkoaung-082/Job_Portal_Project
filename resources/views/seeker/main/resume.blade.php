@extends('seeker.layouts.master')

@section('title')
    Resume
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">

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
                            <li class="list-group-item p-2 mb-2">

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
                            <li class="{{ request()->routeIs('seeker#resume') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
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


            <div class="col-10 ">
                <div class="row text-center">
                    @if (count($data) != 0)
                        @foreach ($data as $d)
                            <embed src="{{ asset('storage/seeker/' . $d->resume) }}" type="application/pdf" width="100%"
                                height="800px">
                        @endforeach
                    @else
                        <p>There is no resume!</p>
                    @endif
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
        </div>
    </div>
@endsection

@section('scriptcode')
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
