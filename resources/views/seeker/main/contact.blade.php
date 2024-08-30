@extends('seeker.layouts.master')

@section('title')
    Contact Page
@endsection

@section('content')
    <div class="container-fluid my-4">
        {{-- <div class="row text-center">
            <div class="col-6 offset-3">
                @if (session('sendSuccess'))
                    <div class=" my-3">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><i class="fa-key fa-solid"></i> {{ session('sendSuccess') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div> --}}
        <div class="row">
            <div class="col-6 offset-3">
                <form action="{{route('seeker#contactfunc')}}" method="post" class="my-5">
                    @csrf
                    <div class="mb-2 text-center">
                        <h2>Contact to Admin</h2>
                    </div>
                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                    <div class="mb-2">
                        <label for="gmail" class="fw-bold mb-2">Gmail</label>
                        <input type="text" name="email" id="" class=" form-control" value="{{Auth::user()->email}}">
                    </div>
                    <div class="mb-2">
                        <label for="description" class="fw-bold mb-2">Description</label>
                        <textarea name="description" id="" cols="30" rows="5" class=" form-control @error('description')
                            is-invalid
                        @enderror"></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-2 text-center">
                        <button type="submit" class=" btn btn-primary">
                            <i class="fa-regular fa-paper-plane"></i> Send
                        </button>
                    </div>
                </form>
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
        @if (session('sendSuccess'))
        Toast.fire({
                                icon: "success",
                                title: "{{ session('sendSuccess') }}"
                            });

        @endif

       
    });
</script>
    
@endsection