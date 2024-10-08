@extends('admin.layouts.main')

@section('title')
    Category Edit
@endsection

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3 offset-8">
                        <a href="{{ route('admin#categorylist') }}"><button
                                class="btn bg-dark text-white my-3">List</button></a>
                    </div>
                </div>
                <div class="col-lg-6 offset-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Your Category</h3>
                            </div>
                            <hr>
                            <form action="{{ route('admin#categoryupdate') }}" method="post" novalidate="novalidate">
                                @csrf
                                <div class="form-group mb-2">
                                    <input type="hidden" name="id" value = "{{ $data->id }}">
                                    <label for="cc-payment" class="control-label mb-1">Name</label>
                                    <input id="cc-pament" name="categoryName" type="text"
                                        value="{{ old('categoryName', $data->name) }}"
                                        class="form-control @error('categoryName') is-invalid @enderror"
                                        aria-required="true" aria-invalid="false" placeholder="Seafood...">
                                    @error('categoryName')
                                        <span class="text-danger invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-center">
                                    <button id="payment-button" type="submit" class="btn btn-sm btn-info btn-block">
                                        <span id="payment-button-amount">Update</span>

                                        <i class="fa-solid fa-circle-right"></i>
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
@endsection
