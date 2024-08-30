<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{asset('admin/images/icon/logonext.jpg')}}">
    <title>@yield('title')</title>
   
    {{-- CSS link --}}
    @vite('public/css/main.css')
    
    <!-- google fonts -->
    <link rel="stylesheet" href="{{asset('poppins/Poppins-Regular.ttf')}}">

    <link href="{{asset('admin/vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />

    <link rel="stylesheet" href="{{asset('sweetalert2/dist/sweetalert2.css')}}">
</head>

  {{-- script --}}
  <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
  <script type="text/javascript">
      bkLib.onDomLoaded(nicEditors.allTextAreas);
  </script>

<body class="guest-bg">
    <section class="header-navbar sticky-top p-0">
        <nav class="navbar navbar-expand-lg bg-white shadow-sm w-100">
            <div class="container  animate__fadeInDown" >
                <img src="{{ asset('admin/images/icon/svglogo.svg') }}" alt="" width="140px" height="80px">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="{{ request()->routeIs('guest#home') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" aria-current="page" href="{{route('guest#home')}}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('guest#allJob') ? 'headerActive' : '' }} {{ request()->routeIs('guest#serachJob') ? 'headerActive' : '' }} {{ request()->routeIs('guest#filterJob') ? 'headerActive' : '' }} {{ request()->routeIs('guest#detailJob') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{route('guest#allJob')}}">Jobs</a>
                        </li>
                        <li class="{{ request()->routeIs('guest#viewcompany') ? 'headerActive' : '' }} {{ request()->routeIs('guest#searchCompany') ? 'headerActive' : '' }} {{ request()->routeIs('guest#companydetail') ? 'headerActive' : '' }} {{ request()->routeIs('guest#companydetail1') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{ route('guest#viewcompany') }}">Companies</a>
                        </li>
                        <li class="{{ request()->routeIs('guest#news') ? 'headerActive' : '' }} {{ request()->routeIs('guest#details') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{route('guest#news')}}">Contents</a>
                        </li>
                        <li class="{{ request()->routeIs('guest#about') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{route('guest#about')}}">About</a>
                        </li>
                    </ul>
                    <div class=" d-flex justify-content-center align-items-center">
                        <span class="text-secondary me-2">
                            Guest Account
                        </span>
                        <span>
                            <a href="{{route('auth#loginPage')}}" class="btn btn-sm btn-primary">SignUp</a>
                        </span>
                    </div>
                </div>
            </div>
        </nav>
    </section>

    @yield('content')


    <section class="footer container-fluid bg-primary">
        <div class="container text-white">
            <footer class="py-3">
                <div class=" pt-xl-2 pt-md-2 my-lg-4 border-top footsection">
                    <p> &copy; 2024 Next-Gen Job Matching, All rights reserved.</p>
                    <ul class="list-unstyled d-flex logosection">
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
            </footer>
        </div>
    </section>

    {{-- jQuery link --}}
    <script src="{{ asset('admin/vendor/jquery-3.2.1.min.js') }}"></script>

    {{-- bootstrap js link --}}
    <script src="{{asset('bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{asset('admin/vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('sweetalert2/dist/sweetalert2.js')}}"></script>
    @yield('scriptcode')
</body>

</html>