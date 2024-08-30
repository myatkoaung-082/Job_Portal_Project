<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('admin/images/icon/logonext.jpg')}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('public/css/main.css')

    {{-- customize your title name --}}
    <title>@yield('title')</title>

    {{-- google fonts --}}
    <link rel="stylesheet" href="{{asset('poppins/Poppins-Regular.ttf')}}">

    {{-- sweet alert --}}
    <link rel="stylesheet" href="{{asset('sweetalert2/dist/sweetalert2.css')}}">

    
</head>
<style>
    /* body{
        font-family: "Raleway", sans-serif;
        font-optical-sizing: auto;
        font-weight: 300;
        font-style: normal;
    } */

    /* @yield('style') */
</style>

<body>
    <div class="container-fluid">
        <div class="row min-vh-100 min-vw-100 mb-2">
            <div class=" col-lg-2 bg-primary text-center p-2">

                {{-- logo section  --}}
                <div class="logo d-flex justify-content-center align-items-center">
                    <img src="{{ asset('admin/images/icon/svglogo.svg') }}" class="rounded rounded-circle"
                        alt="Next" width="100px">
                    <span class="text-white">NEXT <br> <small><i>Job Portal</i></small></span>
                </div>

                {{-- admin list style  --}}
                <div class=" d-flex justify-content-center align-items-center">
                    <ul class="list-group-primary ps-0 text-start list-unstyled">
                        <li class="{{ request()->routeIs('admin#dashboard') ? 'sideActive' : ''}} list-group-item p-2 mb-2" >
                            <a href="{{ route('admin#dashboard') }}" class=" text-decoration-none text-light d-flex align-items-center fs-6 ">
                                <i class="fa-regular fa-rectangle-list me-2"></i>
                                <small>Dashboard</small>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin#inbox') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
                            <a href="{{route('admin#inbox')}}" class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                <i class="fa-regular fa-envelope me-2 " style="width:20px;"></i> <small>Inbox</small>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin#allJob') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
                            <a href="{{route('admin#allJob')}}" class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                <i class="fa-solid fa-briefcase me-2 " style="width:20px;"></i> <small>Jobs</small>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin#categorylist') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
                            <a href="{{route('admin#categorylist')}}" class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                <i class="fa-solid fa-layer-group me-2" style="width:20px;"></i> <small>Category</small>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin#professionlist') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
                            <a href="{{route('admin#professionlist')}}" class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                <i class="fa-solid fa-layer-group me-2" style="width:20px;"></i> <small>Profession</small>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin#industrylist') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
                            <a href="{{route('admin#industrylist')}}" class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                <i class="fa-solid fa-industry me-2" style="width:20px;"></i> <small>Industry</small>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('blog#list') ? 'sideActive' : ''}} list-group-item p-2 mb-2">
                            <a href="{{ route('blog#list') }}" class=" text-decoration-none text-light d-flex align-items-center fs-6">
                                <i class="fa-regular fa-newspaper me-2 " style="width:20px;"></i> <small>Contents</small>
                            </a>
                        </li>
                        <hr class="text-light ">
                        <li class="list-group-item p-2 mb-2">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-light p-2">
                                    <i class="fa-solid fa-right-from-bracket me-2 " style="width:20px;"></i>
                                    <small>Logout</small>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
            <div class=" col-lg-10 bg-light">

                {{-- header section  --}}
                <div class="row d-flex justify-content-center align-items-center mt-4 p-2">
                    <div class="col-2 text-start">
                    <b>Welcome</b> {{Auth::user()->name}}
                    </div>

                    <div class="col-4 offset-6 d-flex justify-content-end align-items-center">

                        {{-- account function  --}}
                        <div class="dropdown">
                            <button class="btn btn-light shadow-sm dropdown-toggle align-items-center" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                @if (Auth::user()->image == null)
                                    <img src="{{ asset('image/default_user.jpg') }}"
                                    class=" img-thumbnail rounded-circle" width="25px">
                                @else
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}" width="25px"/>
                                @endif
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="" class="dropdown-item my-1">
                                        @if (Auth::user()->image == null)
                                            @if (Auth::user()->gender == 'male')
                                                <img src="{{ asset('image/default_user.jpg') }}"
                                                    class=" img-thumbnail rounded-circle" width="25px">
                                            @else
                                                <img src="{{ asset('image/female_default_user.jpg') }}"
                                                    class=" img-thumbnail rounded-circle" width="25px">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/' . Auth::user()->image) }}" width="50px"/>
                                        @endif
                                        {{ Auth::user()->name }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item my-1" href="{{ route('admin#info') }}">
                                        <i class="fa-user fa-solid me-1" style="width:20px;"></i> <small>Account</small>
                                    </a>
                                </li>
                                <li class=" text-center">
                                    <a class="dropdown-item my-1" href="{{ route('admin#changePasswordPage') }}">
                                        <i class="fa-key fa-solid me-1" style="width:20px;"></i> <small>Change Password</small>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- header section end  --}}

                <hr>

                @yield('content')

            </div>
        </div>
        <div class="row bg-primary">
            <div class="d-flex flex-column flex-sm-row justify-content-between p-3 my-3">
                <p class="text-light">&copy; 2024 Next-Gen Job Matching, All rights reserved.</p>
                <ul class="list-unstyled d-flex">
                    <li class="ms-3">
                        <a class="link-body-emphasis" href="#"><i
                                class="fa-brands fa-facebook text-white"></i></a>
                    </li>
                    <li class="ms-3">
                        <a class="link-body-emphasis" href="#"><i
                                class="fa-brands fa-twitter text-white"></i></a>
                    </li>
                    <li class="ms-3">
                        <a class="link-body-emphasis" href="#"><i
                                class="fa-brands fa-instagram text-white"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script src="{{asset('admin/vendor/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('sweetalert2/dist/sweetalert2.js')}}"></script>
    @yield('scriptcode')
</body>

</html>
