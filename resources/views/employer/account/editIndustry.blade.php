@extends('employer.layouts.master')

@section('title')
    Edit Industry
@endsection

@section('content')
    <div class="container-fluid mb-3">
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
                        <div class=" text-light fs-5 fw-bold mt-1">
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
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-light p-2">
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

            <div class="col-lg-10">

                <form action="{{ route('employer#updateIndustry') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="companyBasicInformationCard border border-1 overflow-hidden rounded mt-3">
                                <div class="card-top d-flex align-item-center justify-content-center">
                                    <div
                                        class="card-header-border shadow d-flex align-items-center justify-content-center  bg-primary text-light">
                                        <h5 class="mb-0">Edit Industry</h5>
                                    </div>
                                </div>

                                <div class=" my-3">
                                    <div class="row justify-content-evenly">
                                        <div class="col-9 col-lg-5">

                                            <div class="mb-2">
                                                <label class="mb-2 ms-2 fw-bold">Industry</label>
                                                <div class="mb-1">

                                                    <select class="form-select selectState" id="selectState"
                                                        aria-label="Default select example" name="industryId">
                                                        <option value="">Select Industry</option>
                                                        @foreach ($industries as $i)
                                                            <option value="{{ $i->id }}"
                                                                @if ($industry->company_industry_id == $i->id) selected @endif>
                                                                {{ $i->industry_name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    @error('industryId')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>
                                            </div>




                                            <input type="hidden" name="companyIndustryId"
                                                value="{{ $industry->companyIndustryId }}">
                                            <input type="hidden" name="companyId" value="{{ Auth::user()->id }}">

                                        </div>
                                        <div class="col-9 col-lg-5 d-flex align-items-end justify-content-center">

                                            <div class="">
                                                <button type="submit" class="btn btn-outline-primary">Update</button>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </form>
                <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                    <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;" onclick="history.back()">
                        <i class="fa-solid fa-circle-left fs-4"></i>
                    </button>
                </div>

            </div>
            {{-- ------------ --}}
        </div>
    </div>
@endsection

@section('scriptcode')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#checkPurchaseStatus').click(function() {
                $.ajax({
                    url: '{{ route('employer#checkUserStatus') }}',
                    type: 'get',
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
            }
        })
    </script>
@endsection
