@extends('../../layouts/master');

@section('title')
    Forgot Password
@endsection

@section('hello')
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <form action="{{route('admin#verifyOtp')}}" method="post" class=" shadow-sm mt-5 p-2 rounded-1">
                    @csrf
                    <div class="mb-2 text-center">
                        <h2>Forgot Password</h2>
                    </div>
                    <div class="mb-2 text-center">
                        @if(session('incorrect'))
                            <div class=" my-3">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong><i class="fa-key fa-solid"></i> {{ session('incorrect') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="mb-2">
                        <input type="hidden" name="email" id="" value="{{ $email }}">
                    </div>
                    <div class="mb-2">
                        <label for="email">Otp</label>
                        <input type="number" name="number" id="number" class="form-control" placeholder="Please enter code">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-sm btn-primary"> <i class="fa-solid fa-paper-plane"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection