@extends('admin.layouts.main')

@section('title')
    Job Post Charts
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-8 text-start">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ route('admin#empdatalist') }}"
                                class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-user-tie me-1 " style="width:20px;"></i> <small>Companies</small>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin#employeelist') }}"
                                class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-users me-1 " style="width:20px;"></i> <small>Seekers</small>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin#applyList') }}"
                                class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-user-group me-1 " style="width:20px;"></i>
                                <small>ApplyList</small>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin#transactionList') }}"
                                class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-users-gear me-1 " style="width:20px;"></i>
                                <small>TransactionList</small>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin#chartData')}}" class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-magnifying-glass-chart me-1" style="width:20px;"></i>
                                <small>Data Analysis</small>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mx-auto">
            {{-- <div class="col-8">
                <a href="{{ route('admin#gender') }}" class="btn btn-outline-info text-center text-dark border-0 me-2" style="width:100px;">
                    <img src="{{asset('image/noun-album-folder-7091249.svg')}}" alt="" width="80px" height="80px">
                    <span>Seeker Gender</span>
                </a>
                <a href="{{ route('admin#prochart') }}" class="btn btn-outline-info text-center text-dark border-0 me-2" style="width:100px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Title Usage</span>
                </a>
                <a href="{{ route('admin#industrychart') }}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Industry Status</span>
                </a>
                <a href="{{ route('admin#jobpostchart') }}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Job Posts</span>
                </a>
                <a href="{{route('admin#popularjob')}}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Job Trends</span>
                </a>
                <a href="{{route('admin#purchase')}}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Plan Purchases</span>
                </a>
            </div> --}}
            <div class="col-8">
                <a href="{{ route('admin#gender') }}" class="btn btn-outline-info text-center text-dark border-0 me-2" style="width:100px; height:127px;">
                    <img src="{{asset('image/noun-album-folder-7091249.svg')}}" alt="" width="80px" height="80px">
                    <span>Seeker Gender</span>
                </a>
                <a href="{{ route('admin#prochart') }}" class="btn btn-outline-info text-center text-dark border-0 me-2" style="width:100px; height:127px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Title Usage</span>
                </a>
                <a href="{{ route('admin#industrychart') }}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px; height:127px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Industry Status</span>
                </a>
                <a href="{{ route('admin#jobpostchart') }}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px; height:127px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Job Posts</span>
                </a>
                <a href="{{route('admin#popularjob')}}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px; height:127px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Job Trends</span>
                </a>
                <a href="{{route('admin#purchase')}}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px; height:127px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Monthly Income</span>
                </a>
                {{-- <a href="{{route('admin#totalRevenue')}}" class="btn btn-outline-info text-center text-dark border-0 me-2"
                    style="width:100px; height:127px;">
                    <img src="{{ asset('image/noun-album-folder-7091249.svg') }}" alt="" width="80px"
                        height="80px">
                    <span>Total Revenue</span>
                </a> --}}
            </div>
        </div>

    </div>
@endsection
