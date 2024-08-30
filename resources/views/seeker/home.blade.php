@extends('seeker.layouts.master')

@section('title')
    Dashboard
@endsection

@section('content')

    @if($availableStatus->available_status && $exists)

    @if ($availableStatus->available_status == 1 && $exists)
        <script>
            // Check if the dialog has already been shown
            if (!localStorage.getItem('dialogShown')) {
                // Wait 10 seconds before showing the dialog
                setTimeout(() => {
                    Swal.fire({
                        title: 'Are you available now?',
                        // title: 'မင်း အားနေသေးလား။',
                        text: "Please let us know if you are available.",
                        // text: "သင် အား/မအား ကျွန်ုပ်တို့ကို သိခွင့်ပြုပါ။",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        // Set flag in localStorage to indicate the dialog has been shown
                        localStorage.setItem('dialogShown', 'true');

                        // Check which button was clicked
                        if (result.isConfirmed) {
                            // Submit the 'available-form' if 'Yes' was clicked
                            Swal.fire('Okay!', 'We will check back later.', 'info');
                            setTimeout(() => {
                                const form = document.getElementById('available-form');
                                form.submit();
                            }, 4000);
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Submit the 'unavailable-form' if 'No' was clicked
                            Swal.fire('Great!', 'Thank you for letting us know.', 'success');
                            setTimeout(() => {
                                const form = document.getElementById('unavailable-form');
                                form.submit();

                            }, 4000);
                        }
                    });
                }, 3000); // 10 seconds delay
            }
        </script>
    @endif

    @endif

    <div class=" container-fluid">
        <div class="row min-vh-100 min-vw-100">

            <form id="available-form" action="{{ route('seeker#available') }}" method="POST" style="display: none;">
                @csrf

            </form>

            <form id="unavailable-form" action="{{ route('seeker#unavailable') }}" method="POST" style="display: none;">
                @csrf

            </form>

            <!-- sidebar start -->
            <div class="col-lg-2 bg-primary shadow-sm">
                <div class="sidebar p-2">
                    <!-- company name start -->
                    <div class="sidebar-name d-flex align-items-center justify-content-center">
                        <span class=" text-light fs-5 fw-bold mt-3 ">{{ Auth::user()->name }}</span>
                    </div>
                    <!-- company name end -->
                    <hr class=" text-light">
                    <!-- sidebar list start -->
                    <div class="sidebar-list d-flex align-items-center justify-content-center">
                        <ul class="list-group ps-0 text-start list-unstyled">
                            <li class="{{ request()->routeIs('seeker#home') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
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


            <!-- main content start -->

            <div class="col-lg-10 mb-5">
                <!-- view list start -->
                <div class="view-list">
                    <div class="row col-lg-4 offset-8">
                        @if (session('createSuccess'))
                            <div class=" my-3 text-center">
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <strong><i class="fa-key fa-solid"></i> {{ session('createSuccess') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row mt-3 p-5">
                        <!-- all job start -->
                        <div class="col-lg-4 ">
                            <div class="card mx-auto shadow" style="width: 238px;">
                                <div class="card-body d-flex flex-row align-items-center justify-content-around">
                                    <div class="card-icon">
                                        <i class="fa-solid fa-database text-primary fs-2"></i>
                                    </div>
                                    <div class="card-content text-primary">
                                        <h5 class="card-title">
                                            @if (isset($data))
                                                {{count($data)}}+
                                            @else
                                                0+
                                            @endif
                                        </h5>
                                        <p class="card-text">Total Job Applicants</p>
                                    </div>
                                </div>
                                <div class="card-footer bg-primary text-center">
                                    <a href="{{route('seeker#applyJobPage')}}" class="btn btn-light text-dark my-1  shadow-sm">View All</a>
                                </div>
                            </div>
                        </div>
                        <!-- all job end -->

                    </div>
                </div>

                <!-- plan list end -->
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
            <!-- main content end -->
        </div>
    </div>
@endsection


@section('scriptcode')
<script>
    document.getElementById('logout').addEventListener('click', function() {

        localStorage.removeItem('dialogShown');


    });

    document.getElementById('delete').addEventListener('click', function() {

        localStorage.removeItem('dialogShown');


    });

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

<script>
    $(document).ready(function() {

       wow = new WOW({
           boxClass: 'wow', // default
           animateClass: 'animate__animated', // default
           offset: 0, // default
           mobile: true, // default
           live: true // default
       })
       wow.init();
   })

  

  
</script>
@endsection

