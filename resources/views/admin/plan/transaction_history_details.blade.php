@extends('admin.layouts.main')

@section('title')
    Transaction History Details
@endsection

@section('content')
    <div class=" container-fluid mb-3">
        <div class="row min-vh-100 min-vw-100">

            <!-- main content start -->
            <div class="col-lg-10">
                <div class="row mt-3">
                    <div class="col-lg-10 offset-1">
                        <div class="card shadow-sm">
                            <div class=" card-header bg-primary text-light">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Transaction History Details</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 offset-2">
                                        <img src="{{ asset('storage/transactionSlip/' . $data->transaction_slip) }}"
                                            style=" height:270px; width:180px;" />

                                    </div>
                                    <div class="col-5 offset-1  ">
                                        <div class="my-2 text-primary"><i class="fa-solid fs-5 me-2 text-primary fa-user"
                                                style="width: 20px;"></i>{{ $data->account_name }}</div>
                                        <div class="my-2 text-primary"><i class="fa-solid fs-5 me-2 text-primary fa-phone"
                                                style="width: 20px;"></i>{{ $data->account_phone }}</div>
                                        <div class="my-2 text-primary"><i
                                                class="fa-solid fs-5 me-2 text-primary fa-hourglass-start"
                                                style="width: 20px;"></i>{{ $data->purchase_date }}</div>
                                        <div class="my-2 text-primary"><i
                                                class="fa-solid fs-5 me-2 text-primary fa-hourglass-end"
                                                style="width: 20px;"></i>{{ $data->expire_date }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="backBtn position-fixed " style="right: 70px;bottom:59px;width:50px;height:50px;">
                    <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;" onclick="history.back()">
                        <i class="fa-solid fa-circle-left fs-4"></i>
                    </button>
                </div>
            </div>
            <!-- main content end -->
        </div>
    </div>
@endsection

@section('scriptcode')
    <script>
        $(document).ready(function() {
            $('#checkPurchaseStatus').click(function() {
                $.ajax({
                    url: '{{ route('employer#checkUserStatus') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.status == 1) {
                            window.location.href =
                                '{{ url('employer/createPage') }}'; // Adjust URL as needed
                        } else {
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
                            Toast.fire({
                                icon: "warning",
                                title: "You need to subscribe plan"
                            });
                        }

                    }

                });
            })
        })
    </script>
@endsection
