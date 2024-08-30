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

<body>

    <section class="header-navbar sticky-top p-0">
        <nav class="navbar navbar-expand-lg bg-white shadow-sm w-100">
            <div class="container" >
                <img src="{{ asset('admin/images/icon/svglogo.svg') }}" alt="" width="140px" height="80px">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="{{ request()->routeIs('seeker#homepage') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" aria-current="page" href="{{route('seeker#homepage')}}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('seeker#allJob') ? 'headerActive' : '' }} {{ request()->routeIs('seeker#detailJob') ? 'headerActive' : '' }} {{ request()->routeIs('seeker#serachJob') ? 'headerActive' : '' }} {{ request()->routeIs('seeker#filterJob') ? 'headerActive' : '' }} nav-item"> 
                            <a class="nav-link text-green" href="{{route('seeker#allJob')}}">Jobs</a>
                        </li>
                        <li class="{{ request()->routeIs('seeker#viewcompany') ? 'headerActive' : '' }} {{ request()->routeIs('seeker#companydetail1') ? 'headerActive' : '' }} {{ request()->routeIs('seeker#searchCompany') ? 'headerActive' : '' }} {{ request()->routeIs('seeker#companydetail1') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{ route('seeker#viewcompany') }}">Companies</a>
                        </li>
                        <li class="{{ request()->routeIs('seeker#news') ? 'headerActive' : '' }} {{ request()->routeIs('seeker#details') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{route('seeker#news')}}">Contents</a>
                        </li>
                        <li class="{{ request()->routeIs('seeker#about') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{route('seeker#about')}}">About</a>
                        </li>
                        <li class="{{ request()->routeIs('seeker#contact') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{route('seeker#contact')}}">Contact</a>
                        </li>
                    </ul>
                    <a href="{{route('seeker#home')}}" class="btn btn-primary">Dashboard</a>
                </div>
            </div>
        </nav>
    </section>

    @yield('content')


    <section class="footer container-fluid bg-primary">
        <div class="container text-white">
            <footer class="py-3">
                <div class="d-flex flex-column flex-sm-row justify-content-between pt-2 my-4 border-top">
                    <p>&copy; 2024 Next-Gen Job Matching, All rights reserved.</p>
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