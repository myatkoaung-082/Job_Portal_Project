@extends('employer.layouts.master')

@section('title')
    Job Apply Details
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
            <div class="col-lg-9 ">
                <div class="row mt-3">
                    @foreach ($data as $d)
                        <div class="col-lg-3">
                            <div class="card shadow-sm " style="height: 240px;">
                                <div class="card-body">
                                    <div class=" d-flex flex-column align-items-center justify-content-center">
                                        <div class="">
                                            @if ($image->image == null)
                                                <img src="{{ asset('image/default_user.jpg') }}" alt=""
                                                    class="profileLogo img-thumbnail" width="150px" height="150px">
                                            @else
                                                <img src="{{ asset('storage/seeker/' . $d->profile_image) }}"
                                                    alt="" class="profileLogo img-thumbnail"
                                                    style=" object-fit:cover;" width="150px" height="150px">
                                            @endif
                                        </div>
                                        <div class="text-center mt-3">
                                            <h6 class=" text-primary fw-medium mb-0">{{ $d->seekerName }}</h6>
                                            <small class=" text-muted">{{ $d->proTitleName }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            {{-- personal info start --}}
                            <div class="card shadow-sm me-auto" style="height: 240px;">
                                <div class="card-body">
                                    <h5 class="text-primary">Personal Background</h5>
                                    <div class=" row">
                                        <div class="col-lg-5">
                                            <p><strong>Email:</strong><br>{{ $d->email }}</p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p><strong>Gender:</strong><br>{{ $d->gender }}</p>
                                        </div>
                                        <div class="col-lg-4">
                                            <p><strong>Phone:</strong><br>{{ $d->phone }}</p>
                                        </div>

                                    </div>
                                    <div class=" row">
                                        <div class="col-lg-5">
                                            <p><strong>Address:</strong><br>{{ $d->address }} , {{ $d->township_name }}
                                                , {{ $d->state_name }}</p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p><strong>Martial Status:</strong><br>{{ $d->martial_status }}</p>
                                        </div>
                                        <div class="col-lg-4">
                                            <p><strong>Date of Birth:</strong><br>{{ $d->dob }}</p>
                                        </div>

                                    </div>
                                    <div class="row pb-2">
                                        <div class="col-lg-4 offset-8">
                                            <a href="{{ route('employer#viewResume', $d->seekerId) }}"
                                                class=" btn btn-sm btn-primary">View Resume</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- personal info end --}}

                            {{-- experience start --}}
                            <div class="accordion mt-2" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            Experience
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class="list-group ps-0 text-start list-unstyled">
                                                @if (count($empHistory) != null)
                                                    @foreach ($empHistory as $eh)
                                                        <li class="list-group-item p-1">
                                                            <strong>{{ $eh->company_name }}</strong>
                                                            <p class=" mb-0">{{ $eh->Department }} | {{ $eh->Position }}
                                                            </p>
                                                            <p class=" text-muted">From: {{ $eh->Start_Date }} To:
                                                                {{ $eh->End_Date }}</p>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li class="list-group-item p-1">
                                                        <strong>There is no employment history!</strong>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- experience end --}}

                            {{-- education start --}}
                            <div class="accordion mt-2" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Education
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class="list-group ps-0 text-start list-unstyled">
                                                @if (count($education) != null)
                                                    @foreach ($education as $e)
                                                        <li class="list-group-item p-1">
                                                            <strong>{{ $e->institute_name }}</strong>
                                                            <p class=" mb-0">{{ $e->area_of_studies }}</p>
                                                            <p class=" text-muted"> {{ $e->degree_level }} |
                                                                {{ $e->passing_year }}</p>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li class="list-group-item p-1">
                                                        <strong>There is no educational background!</strong>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- education end --}}

                            {{-- skill start --}}
                            <div class="accordion mt-2" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                            aria-controls="collapseOne">
                                            Skill & Languages
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <ul class="list-group ps-0 text-start list-unstyled">
                                                @if (count($skill) != null)
                                                    @foreach ($skill as $s)
                                                        <li class="list-group-item p-1">
                                                            <p> <strong>{{ $s->skill_name }}</strong> (
                                                                {{ $s->skill_level }}
                                                                ) </p>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li class="list-group-item p-1">
                                                        <strong>There is no skill & language!</strong>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- skill end --}}
                        </div>
                    @endforeach
                </div>
                <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                    <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle"
                        style="line-height: 0;" onclick="history.back()">
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
            <!-- main content end -->
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
