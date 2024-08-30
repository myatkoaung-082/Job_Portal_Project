@extends('admin.layouts.main')

@section('title')
    Admin Job List
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <form action="{{ route('admin#searchJob') }}" method="get" class="wow animate__fadeInDown">
                @csrf
                <div class="row my-3">
                    <div class=" col-lg-3">
                        <div class="input-form">
                            <i class="fa-solid fa-building fs-6 text-primary"></i>
                            <input type="text" name="searchKey" class="input" placeholder="Enter Company Name"
                                value="{{ request('searchKey') }}">
                        </div>
                    </div>
                    <div class=" col-lg-2">
                        <div class="input-form">
                            <i class="fa-solid fa-arrow-up-short-wide text-primary fs-6"></i>
                            <select name="orderBy" id="" class=" input">
                                <option value="">Sort By Date</option>
                                <option value="asc" @if (request('orderBy') == 'asc') selected @endif>Ascending</option>
                                <option value="desc" @if (request('orderBy') == 'desc') selected @endif>Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit"
                            class="btn btn-primary text-light input-form w-100 d-flex align-items-center justify-content-center"><i
                                class="fa-solid fa-magnifying-glass me-2"></i>SEARCH</button>
                    </div>
                    <div class=" col-lg-4 offset-1">
                        @if (session('deleteSuccess'))
                            <div class="">
                                <div class="alert alert-info text-dark alert-dismissible fade show" role="alert">
                                    <strong><i class="fa-solid fa-check me-2 fs-6"></i>
                                        {{ session('deleteSuccess') }}</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </form>

        </div>
        <div class="all-jobs d-flex flex-column align-items-center justify-content-center mt-5">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab"
                    tabindex="0">
                    <table class="table">

                        <thead class="border-bottom-1">
                            <tr>
                                <th scope="col">Company Name</th>
                                <th scope="col">Job Info:</th>
                                <th scope="col">Posted Date</th>
                                <th scope="col">Expired Date</th>
                                <th scope="col">Total Applied</th>
                                <th scope="col">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) != null)
                                @foreach ($data as $d)
                                    <tr class="tr-shadow">
                                        <td>{{ $d->companyName }}</td>
                                        <td>
                                            <div class="">{{ $d->professional_title_name }}</div>
                                            <div class=""><small>{{ $d->industry_name }}</small></div>
                                        </td>
                                        <td>{{ $d->created_at }}</td>
                                        <td>{{ $d->apply_expire_date }}</td>
                                        <td>{{ $d->total_job }}</td>
                                        <td style="width: 100px">
                                            <a href="{{ route('admin#detailsJob', $d->jobId) }}"
                                                class="btn btn-sm btn-outline-info me-1" data-toggle="tooltip" data-placement="top"
                                                title="detail">

                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <form id="delete-form" action="" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button class="btn btn-sm btn-outline-danger" data-toggle="tooltip"
                                            data-placement="top" title="Delete" onclick="confirmDelete('{{ route('admin#jobDelete', $d->jobId) }}')"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class=" text-center">
                                    <td colspan="6">There is no job for your searching!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        {{ $data->appends(request()->query())->links() }}
    </div>
@endsection

@section('scriptcode')
    <script>
        function confirmDelete(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the action of the hidden form to the URL
                    const form = document.getElementById('delete-form');
                    form.action = url;

                    // Submit the form
                    form.submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const toast = Swal.mixin({
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
            @if (session('success'))
            toast.fire({
                                    icon: "success",
                                    title: "{{ session('success') }}"
                                });

            @endif
        });
    </script>
@endsection