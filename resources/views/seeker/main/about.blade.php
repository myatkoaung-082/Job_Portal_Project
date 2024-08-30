@extends('seeker.layouts.master')

@section('title')
    About Page
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 text-center text-primary aboutPage d-flex justify-content-evenly align-items-center">
            <div class="">
                <img src="{{asset('image/undraw_wait_in_line_o2aq.svg')}}" class=" wow animate__fadeInLeft" alt="" width="250px">
            </div>
            <div class="wow animate__fadeInRight">
                <h2 class="mb-3 fw-bold">About Us</h2>
                <p class="">
                    Every problem is a gift - without problems we would not grow. <br>
                    If you don't build your dream, someone else will hire you to help them build theirs.
                </p>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12 text-center wow animate__fadeInUp">
            <h2 class="my-5 fw-bold">Passion</h2>
            <div class="d-flex justify-content-center align-items-center my-5">
                <div class=" rounded-circle  bg-primary text-light d-flex align-items-center justify-content-center me-4" style="height: 200px; width: 200px;" id="one">
                    <b>RELIABILITY</b>
                </div> 
                <div class=" rounded-circle  bg-primary text-light d-flex align-items-center justify-content-center me-4" style="height: 200px; width: 200px;" id="two">
                    <b>RESPONSIBILITY</b>
                </div> 
                <div class=" rounded-circle  bg-primary text-light d-flex align-items-center justify-content-center" style="height: 200px; width: 200px;" id="three">
                    <b>ACCUARACY</b>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="row wow animate__fadeInUp">
                <h2 class="my-5 fw-bold text-center">Meet Our Team</h2>
                <p class=" text-center">
                    Coming together is a beginning, Staying together is progress <br>
                    Working together is the success <br>
                    <b> You Learn More From Failure Than From Success </b>
                </p>
            </div>
            <div class="row mb-3">
                <div class="col-lg-12 d-flex justify-content-center align-items-center wow animate__fadeInUp">
                    <div class="img-box ms-3 d-flex justify-content-center align-items-end text-light">
                        <p class="mb-2">
                            Thet Pan <br>
                            5CS - 11
                        </p>
                    </div>
                    <div class="img-box1 ms-3 d-flex justify-content-center align-items-end text-light">
                        <p class="mb-2">
                            Zayar Tun <br>
                            5CS - 18
                        </p>
                    </div>
                    <div class="img-box2 ms-3 d-flex justify-content-center align-items-end text-light">
                        <p class="mb-2">
                            Myat Ko Aung <br>
                            5CS - 22
                        </p>
                    </div>
                    <div class="img-box3 ms-3 d-flex justify-content-center align-items-end text-light">
                        <p class="mb-2">
                            Zin Thu Ko <br>
                            5CS - 49
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptcode')

<script>
    $(document).ready(function() {

       wow = new WOW({
           boxClass: 'wow', // default
           animateClass: 'animated', // default
           offset: 0, // default
           mobile: true, // default
           live: true // default
       })
       wow.init();
   })

  
</script>
    
@endsection