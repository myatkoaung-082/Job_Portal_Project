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

    {{-- script --}}
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(nicEditors.allTextAreas);
    </script>
    
    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            api_key:'u0st8ooaimdyc38z60wh35h8legv9smoznsa5imp0iuzwx0x',
            menubar: false,
            plugins: 'lists link image preview',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | preview',
            height: 300
        });
    </script> --}}

    <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />

    <link href="{{asset('admin/vendor/wow/animate.css')}}" rel="stylesheet" media="all">

    <link rel="stylesheet" href="{{asset('sweetalert2/dist/sweetalert2.css')}}">

</head>

<body>
    <section class="header-navbar sticky-top p-0">
        <nav class="navbar navbar-expand-lg bg-white shadow-sm w-100">
            <div class="container">
                <img src="{{ asset('admin/images/icon/svglogo.svg') }}" alt="" width="140px" height="80px">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="{{ request()->routeIs('employer#headerHome') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" aria-current="page" href="{{ route('employer#headerHome') }}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('employer#headerAllJob') ? 'headerActive' : '' }} {{ request()->routeIs('employer#headerSearchJob') ? 'headerActive' : '' }} {{ request()->routeIs('employer#headerFilterJob') ? 'headerActive' : '' }} {{ request()->routeIs('employer#headerDetail') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" aria-current="page" href="{{ route('employer#headerAllJob') }}">Jobs</a>
                        </li>
                        <li class="{{ request()->routeIs('employer#headerViewCompany') ? 'headerActive' : '' }} {{ request()->routeIs('employer#headerSearchCompany') ? 'headerActive' : '' }} {{ request()->routeIs('employer#headerCompanyDetail') ? 'headerActive' : '' }} {{ request()->routeIs('employer#headerCompanyDetail1') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" aria-current="page" href="{{ route('employer#headerViewCompany')}}">Companies</a>
                        </li>
                        <li class="{{ request()->routeIs('employer#news') ? 'headerActive' : '' }} {{ request()->routeIs('employer#details') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{ route('employer#news') }}">Contents</a>
                        </li>
                        <li class="{{ request()->routeIs('employer#about') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{ route('employer#about') }}">About</a>
                        </li>
                        <li class="{{ request()->routeIs('employer#contact') ? 'headerActive' : '' }} nav-item">
                            <a class="nav-link text-green" href="{{ route('employer#contact') }}">Contact</a>
                        </li>
                    </ul>
                    <a href="{{ route('employer#home') }}" class="btn btn-primary shadow-sm">Dashboard</a>
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
    
    {{-- bootstrap JS link --}}
    <script src="{{asset('bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{asset('admin/vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('sweetalert2/dist/sweetalert2.js')}}"></script>

    {{-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('jobDescription');
    </script> --}}

    {{-- <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script> --}}
    @yield('scriptcode')
</body>
</html>
