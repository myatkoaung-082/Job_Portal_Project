@extends('layouts.master')

@section('hello')
    <div class="container min-vh-100">

        <div class="blob1 w-50 position-fixed">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#F1C21B"
                    d="M60.9,-60.9C76.7,-45.1,85.8,-22.5,85.9,0.1C86,22.8,77.2,45.5,61.3,61.6C45.5,77.7,22.8,87,-0.1,87.1C-22.9,87.2,-45.9,78,-62.3,62C-78.8,45.9,-88.7,22.9,-88.8,0C-88.8,-23,-78.9,-46,-62.4,-61.8C-46,-77.6,-23,-86.3,-0.2,-86.1C22.5,-85.8,45.1,-76.7,60.9,-60.9Z"
                    transform="translate(100 100)" />
            </svg>
        </div>

        <div class="blob2 w-50 position-fixed">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#F1C21B"
                    d="M40.7,-55C47.3,-51.1,43.7,-32.1,40.1,-18.8C36.5,-5.5,32.9,2,33.2,13.8C33.5,25.5,37.7,41.6,32.8,46.7C27.9,51.8,13.9,46,2.4,42.7C-9.2,39.4,-18.4,38.6,-33.2,36.8C-48.1,34.9,-68.6,32,-70,23.7C-71.3,15.5,-53.4,2,-41.1,-6.4C-28.8,-14.8,-22.2,-18,-16.2,-22.2C-10.3,-26.4,-5.2,-31.5,5.9,-39.6C17,-47.7,34,-58.9,40.7,-55Z"
                    transform="translate(100 100)" />
            </svg>
        </div>
        <div class="loginForm bg-white d-flex min-vh-100 justify-content-center align-items-center">

            <div class="row flex-sm-column flex-md-row flex-lg-row w-75 shadow-lg z-3 rounded-3 overflow-hidden ">
                <div
                    class=" col-sm-12 col-md-12 col-lg-7 d-flex  bg-white text-center justify-content-center align-items-center wow animate__fadeInLeft">
                    <div class="sigin d-flex flex-column w-75 ">
                        <span class="">
                            <img src="{{ asset('admin/images/icon/logonext.jpg') }}" alt="Next" width="150px">
                        </span>

                        <div class="">
                            <form action="{{ route('login') }}" method="POST" class="">
                                @csrf
                                <div class="form-floating mb-2">
                                    <input type="email" class="form-control" placeholder="Leave a comment here"
                                        id="floatingEmail" name="email"></input>
                                    <label for="floatingEmail"><i class="fa-solid fa-envelope me-2"></i>Email</label>
                                </div>
                                <div class="form-floating">
                                    <input type="password" class="form-control" placeholder="Leave a comment here"
                                        id="floatingPassword" name="password"></input>
                                        <button id="togglePassword" aria-label="Show password"><i class="fa-solid fa-eye"></i></button>
                                    <label for="floatingPassword"><i class="fa-solid fa-key me-2"></i>Password</label>
                                </div>

                                <div class="my-3">
                                    <a href="{{ route('admin#forgortPasswordPage') }}" class="text-decoration-none">Forgot
                                        your password?</a>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary py-2 mb-2 w-50 text-white text-uppercase rounded-pill">Sign
                                    in</button>
                                <a href="{{ route('guest#home') }}"
                                    class="btn btn-info py-2 mb-3 mb-lg-3 w-50 text-dark text-uppercase rounded-pill">Guest</a>
                            </form>
                        </div>

                    </div>

                </div>
                <div class=" col-sm-12 col-md-12 col-lg-5 rounded-3 d-flex justify-content-center bg-primary bg-opacity-0">
                    <div class="signUp wow animate__fadeInRight text-white text-center d-flex flex-column justify-content-center align-items-center w-75 "
                        style="height: 500px;">
                        <h2 class="my-3">Welcome To</h2>
                        <p><b>Next-Gen Job Matching</b> <br> <small>Search & Apply Your Dream Jobs</small> </p><br><br>
                        <small>
                            <p>New to <b>Next-Gen</b>?</p>
                        </small>
                        <a href="{{ route('auth#registerPage') }}"
                            class="btn btn-outline-light shadow-sm rounded-pill w-50">Sign Up</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scriptcode')

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
        @if (session('deactivateSuccess'))
                    Toast.fire({
                                icon: "success",
                                title: "{{ session('deactivateSuccess') }}"
                            });

        @endif
    });

    document.addEventListener('DOMContentLoaded', () => {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('floatingPassword');
        const icon = togglePassword.querySelector('i');

        togglePassword.addEventListener('click', () => {
            // Toggle the type attribute
            event.preventDefault();
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the eye icon
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
</script>

@endsection
