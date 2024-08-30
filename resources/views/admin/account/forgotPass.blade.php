@extends('../../layouts/master')

@section('title')
    Forgot Password
@endsection

@section('hello')
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <form action="{{route('admin#sendOtp')}}" method="post" class=" shadow-sm mt-5 p-3 rounded-1">
                    @csrf
                    <div class="mb-2 text-center">
                        <h2>Forgot Password</h2>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="mb-2 fw-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Please enter your email">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary btn-sm"> <i class="fa-solid fa-paper-plane me-1"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection