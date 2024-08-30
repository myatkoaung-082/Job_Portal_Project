@extends('admin.layouts.main')

@section('title')
    Change Password
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <span class="text-decoration-none bg-primary p-1 text-white rounded-1">
                                    <i class="fa-solid fa-rotate-left" onclick="history.back()"></i>Back 
                                </span>
                                <h3 class="text-center title-2">Change Password</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#changePassword') }}" method="post" novalidate="novalidate" style="font-size: 16px;">
                                @csrf
                                @if(session('passError'))
                                    <div class=" my-3">
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong><i class="fa-key fa-solid"></i> {{ session('passError') }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group mb-2">
                                    <label for="cc-payment" class="control-label mb-1">Old Password</label>
                                    <input id="cc-pament" name="oldPassword" type="password" class="form-control @error('oldPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter old password">
                                    @error('oldPassword')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-2">
                                    <label for="cc-payment" class="control-label mb-1">New Password</label>
                                    <input id="cc-pament" name="newPassword" type="password" class="form-control @error('newPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter new password">
                                    @error('newPassword')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-2">
                                    <label for="cc-payment" class="control-label mb-1">Confirm Password</label>
                                    <input id="cc-pament" name="confirmPassword" type="password" class="form-control @error('confirmPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter confirm password">
                                    @error('confirmPassword')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button id="payment-button" type="submit" class="btn btn-sm btn-primary btn-block">
                                        <i class="fa-solid fa-key"></i> <span id="payment-button-amount">Change</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
@endsection