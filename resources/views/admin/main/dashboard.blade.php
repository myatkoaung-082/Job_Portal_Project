@extends('admin.layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-8 text-start">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{route('admin#empdatalist')}}" class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-user-tie me-1 " style="width:20px;"></i> <small>Companies</small>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin#employeelist')}}" class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-users me-1 " style="width:20px;"></i> <small>Seekers</small>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin#applyList')}}" class=" text-decoration-none d-flex align-items-center fs-6">
                                <i class="fa-solid fa-user-group me-1 " style="width:20px;"></i>
                                <small>ApplyList</small>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin#transactionList')}}" class=" text-decoration-none d-flex align-items-center fs-6">
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
        <div class="row mb-2 d-flex justify-content-center align-items-center">
            <div class="col-6 shadow-sm">
                <div style="width:500px; height:300px;" class=" text-center">
                    <canvas id="barchart1"></canvas>
                </div>
            </div>
            <div class="col-6 shadow-sm">
                <div style="width:500px; height:300px;" class=" text-center">
                    <canvas id="barchart2"></canvas>
                </div>
            </div>
        </div>

        <div class="mb-2 d-flex justify-content-center align-items-center">
            <div class="col-3 m-1">
                <div class="card text-center bg-primary">
                    <div class="card-body text-light" >
                        <div class="card-title">
                            <i class="fa-solid fa-building me-2"></i>Companies
                        </div>
                        <div class="card-text p-2">
                            @if($employer)
                                {{count($employer)}}
                            @else
                                0
                            @endif
                        </div>
                        <a href="{{route('admin#empdatalist')}}" class=" btn btn-sm btn-light"><i class="fa-solid fa-eye me-2"></i>View</a>
                    </div>
                </div>
            </div>
            <div class="col-3 m-1">
                <div class="card text-center bg-primary">
                    <div class="card-body text-light">
                        <div class="card-title">
                            <i class="fa-solid fa-users me-2"></i>Seekers
                        </div>
                        <div class="card-text p-2">
                            @if($seeker)
                                {{count($seeker)}}
                            @else
                                0
                            @endif
                        </div>
                        <a href="{{route('admin#employeelist')}}" class=" btn btn-sm btn-light"><i class="fa-solid fa-eye me-2"></i>View</a>
                    </div>
                </div>
            </div>
            <div class="col-3 m-1">
                <div class="card text-center bg-primary">
                    <div class="card-body text-light">
                        <div class="card-title">
                            <i class="fa-solid fa-users me-2"></i>Apply Lists
                        </div>
                        <div class="card-text p-2">
                            @if($applyList)
                                {{count($applyList)}}
                            @else
                                0
                            @endif
                        </div>
                        <a href="{{route('admin#applyList')}}" class=" btn btn-sm btn-light"><i class="fa-solid fa-eye me-2"></i>View</a>
                    </div>
                </div>
            </div>
            <div class="col-3 m-1">
                <div class="card text-center bg-primary">
                    <div class="card-body text-light">
                        <div class="card-title">
                            <i class="fa-solid fa-file-invoice-dollar me-2"></i>Transaction Lists
                        </div>
                        <div class="card-text p-2">
                            @if($transaction)
                                {{count($transaction)}}
                            @else
                                0
                            @endif
                        </div>
                        <a href="{{route('admin#transactionList')}}" class=" btn btn-sm btn-light"><i class="fa-solid fa-eye me-2"></i>View</a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('scriptcode')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        fetch('/analysis/empdata')
            .then(response => response.json())
            .then(data =>{
                var ctx = document.getElementById('barchart1').getContext('2d');
                var usersChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data['months'],
                        datasets: [{
                            label: 'No of Companies Registered by Month within a Year',
                            data: data['counts'],
                            backgroundColor: 'rgba(22, 33, 51)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })

        fetch('/analysis/seeker')
            .then(response => response.json())
            .then(data =>{
                var ctx = document.getElementById('barchart2').getContext('2d');
                var usersChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data['months'],
                        datasets: [{
                            label: 'No of Seekers Registered by Month within a Year',
                            data: data['counts'],
                            backgroundColor: 'rgba(22, 33, 51)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
    </script>
@endsection