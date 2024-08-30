@extends('admin.layouts.main')

@section('title')
    Purchase Analysis
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-2 text-center">
            <div class="col-12">
                <h3>Monthly Income of Our Website in One Year</h3>
            </div>
        </div>
        {{-- <div class="row mx-auto">
            <div class="col-8">
                <form action="#" method="get" class="my-1 d-flex justify-content-end" id="timeForm">
                    @csrf
                    <div class=" d-flex justify-content-end align-items-center w-50">
                        <div class="d-flex align-items-center">
                            <label for="">Year:</label>
                            <input type="text" name="year" id="" class="form-control" title="Year" value="{{old('year')}}" required>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="">Period:</label>
                            <select name="period" id="">
                                <option value="quarter">Quarter</option>
                                <option value="month">Month</option>
                            </select>
                        </div>
                        <div class="ms-2">
                            <input type="submit" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-12 shadow-sm d-flex justify-content-center align-items-start">
                <div>
                    <canvas id="myChart" width="600" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="backBtn position-fixed " style="right: 30px;bottom:59px;width:50px;height:50px;">
            <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;" onclick="history.back()">
                <i class="fa-solid fa-circle-left fs-4"></i>
            </button>
        </div>
    </div>
@endsection

@section('scriptcode')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- <script>
    fetch('/analysis/getData')
    .then(response => response.json())
    .then(data =>{
        var ctx = document.getElementById('myChart').getContext('2d');
        var usersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data['months'],
                datasets: [{
                    label: 'Total revenue for each month',
                    data: data['counts'],
                    backgroundColor: 'rgba(22, 33, 51)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }],
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
</script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    fetch('/analysis/getData')
    .then(response => response.json())
    .then(data =>{
        var ctx = document.getElementById('myChart').getContext('2d');
        var usersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data['months'],
                datasets: [{
                    label: 'Annual monthly income',
                    data: data['counts'],
                    backgroundColor: 'rgba(22, 33, 51)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return 'MMK ' + value.toLocaleString(); // Add $ to y-axis labels
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ':MMK ' + tooltipItem.raw.toLocaleString(); // Add $ to tooltip label
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection