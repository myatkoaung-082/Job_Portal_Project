@extends('layouts.master')

@section('hello')
    <div id="register-form" class="register-page">
        <div class="form-box shadow bg-light border border-1 rounded-2">
            <div class="logo w-100 d-flex justify-content-center wow animate__fadeInDown">
                <img src="{{ asset('admin/images/icon/svglogo.svg') }}" height="60px" width="150px" alt="" />
            </div>
            <div class="button-box mx-auto shadow-sm wow animate__fadeInDown" style="width: 232px;">
                <div id="btn"></div>
                <button type="button" onclick="userRegister()" class="toggle-btn ">
                    Seeker
                </button>
                <button type="button" onclick="companyRegister()" class="toggle-btn">
                    Company
                </button>
            </div>

            <form action="{{ route('register', 'seeker') }}" method="post" id="userRegisterForm"
                class="input-group-login my-3">
                @csrf
                <div class="row justify-content-evenly">
                    <div class="col-9 col-lg-5 wow animate__fadeInLeft">
                        <div class="">
                            <label class="mb-1 ms-2 fw-bold">Full Name</label>
                            <div class="mb-1">
                                <input type="text" class="form-control @error('name') invalid @enderror" id="name"
                                    placeholder="Enter Full Name" name="name" value="{{ old('name') }}" required />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="name"><i class="bi bi-envelope me-2"></i></label>
                            </div>
                        </div>

                        <div class="">
                            <input type="hidden" name="role" value="seeker">
                        </div>

                        <div class="">
                            <label class="mb-1 ms-2 fw-bold">Email</label>
                            <div class="mb-1">
                                <input type="email"
                                    class="form-control @error('email')
                                      invalid
                                    @enderror"
                                    id="email" placeholder="Enter email" name="email" value="{{ old('email') }}"
                                    required />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="email"><i class="bi bi-envelope me-2"></i></label>
                            </div>
                        </div>


                    </div>

                    <div class="col-9 col-lg-5 wow animate__fadeInRight">

                        <div class="">
                            <label class="mb-1 ms-2 fw-bold">Password</label>
                            <div class="mb-1">
                                <input type="password"
                                    class="form-control @error('password')
                                      invalid
                                @enderror"
                                    id="password" placeholder="Enter password" name="password" required />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="password"><i class="bi bi-envelope me-2"></i></label>
                            </div>
                        </div>

                        <div class="">
                            <label class="mb-1 ms-2 fw-bold">Confirm Password</label>
                            <div class="mb-1">
                                <input type="password"
                                    class="form-control @error('confirm-password')
                                      invalid
                                    @enderror"
                                    id="confirmPassword" placeholder="Enter confirm password" name="confirm-password"
                                    required />
                                @error('confirm-password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="confirmPassword"><i class="bi bi-envelope me-2"></i></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="d-flex flex-column justify-content-center align-items-center w-50 mx-auto my-2 wow animate__fadeInUp">
                    <div class="mb-2 align-items-center">
                        <div class="d-flex align-items-center p-1">
                            <input type="checkbox" name="" id="" required>&nbsp;<a
                                href="{{ route('terms&conds') }}">Terms & Conditions</a>
                        </div>
                    </div>
                    <button class="w-50 btn btn-sm btn-primary" type="submit">
                        Sign Up
                    </button>
                    <div class="mx-auto my-3">
                        <span class="me-2"><small>Already have an account?</small></span>
                        <a href="{{ route('auth#loginPage') }}" class=""><small>SignIn</small></a>
                    </div>
                </div>
            </form>

            <form action="{{ route('register') }}" method="post" id="companyRegisterForm" class="input-group-login">
                @csrf
                <div class="row justify-content-evenly">
                    <div class="col-9 col-lg-5">
                        <div class="">
                            <label class="mb-1 ms-2 fw-bold">Company Name</label>
                            <div class="mb-1">
                                <input type="text"
                                    class="form-control @error('name')
                                      invalid
                                    @enderror"
                                    id="name" placeholder="Enter Full Name" name="name" required />
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="name"><i class="bi bi-envelope me-2"></i></label>

                            </div>
                        </div>

                        <div class="">
                            <input type="hidden" name="role" value="employer">
                        </div>

                        <div class="">
                            <label class="mb-1 ms-2 fw-bold">Email</label>
                            <div class="mb-1">
                                <input type="email"
                                    class="form-control @error('email')
                                      invalid
                                    @enderror"
                                    id="email" placeholder="Enter email" name="email" required />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <label for="email"><i class="bi bi-envelope me-2"></i></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-9 col-lg-5">

                        <div class="">
                            <label class="mb-1 ms-2 fw-bold">Password</label>
                            <div class="mb-1">
                                <input type="password"
                                    class="form-control @error('password')
                                      invalid
                                    @enderror"
                                    id="password" placeholder="Enter password" name="password" required />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="password"><i class="bi bi-envelope me-2"></i></label>
                            </div>
                        </div>

                        <div class="">
                            <label class="mb-1 ms-2 fw-bold">Confirm Password</label>
                            <div class="mb-1">
                                <input type="password"
                                    class="form-control @error('confirm-password')
                                      invalid
                                    @enderror"
                                    id="confirmPassword" placeholder="Enter confirm password" name="confirm-password"
                                    required />
                                @error('confirm-password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <label for="confirmPassword"><i class="bi bi-envelope me-2"></i></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column justify-content-center align-items-center w-50 mx-auto my-2">
                    <div class="mb-2 align-items-center">
                        <div class="d-flex align-items-center p-1">
                            <input type="checkbox" name="" id="" required>&nbsp;<a
                                href="{{ route('terms&conds') }}">Terms & Conditions</a>
                        </div>
                    </div>
                    <button class="w-50 p-2 btn btn-sm btn-primary" type="submit">
                        Sign Up
                    </button>
                    <div class="mx-auto my-3">
                        <span class="me-2"><small>Already have an account?</small></span>
                        <a href="{{ route('auth#loginPage') }}" class="text-decoration-none"><small>SignIn</small></a>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

