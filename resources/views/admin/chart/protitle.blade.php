@extends('admin.layouts.main')

@section('title')
    Professional title Chart
@endsection

@section('style')
    .chart-container{
        margin-top: 0;
        padding-top: 0;
        position: relative;
        top: 0;
    }
@endsection

@section('scriptcode')
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
    
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Professional Title', 'Total Seekers'],
                @foreach($data as $d)
                    ['{{ $d[0] }}', {{ $d[1] }}],
                @endforeach
            ]);

            var options = {
                title: 'Professional Title Usage by Seeker',
                hAxis: {
                    title: 'Total Seekers',
                },
                vAxis: {
                    title: 'Professional Title',
                }
            };

            var chart = new google.visualization.BarChart(document.getElementById('barchart'));

            chart.draw(data, options);
        }
        setInterval(drawChart, 5000);    
    </script>

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
            @if (session('dateError'))
                        Toast.fire({
                                    icon: "error",
                                    title: "{{ session('dateError') }}"
                        });

            @endif
        });
    </script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row shadow-sm mb-2 text-center">
            <div class="col-12">
                <h3>Professional Title Usage by Seekers in Next-Gen Job Matching</h3>
            </div>
        </div>
        <div class="row mx-auto">
            <div class="col-8 offset-2">
                <form action="{{route('admin#seekerSearch')}}" method="post" class="my-2 d-flex justify-content-center">
                    @csrf
                    <div class=" d-flex justify-content-center align-items-center">
                        <div class="d-flex align-items-center ms-2">
                            <label for="">Category:</label>
                            <select name="category" id="" class="form-select">
                                <option value="">Choose Category</option>
                                @foreach ($categoryData as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-center ms-2">
                            <label for="">From:</label>
                            <input type="date" name="startdate" id="" class="form-control" title="Start Date" value="{{old('startdate')}}" required>
                        </div>
                        <div class="d-flex align-items-center ms-2">
                            <label for="">To:</label>
                            <input type="date" name="enddate" id="" class="form-control" title="End Date" value="{{old('enddate')}}" required>
                        </div>
                        <div class="ms-2">
                            <input type="submit" value="Search" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-2 text-center">
            <div class="col-12">
                @if($start_date != null && $end_date != null && $category_name != null)
                    <p class=" fs-6 bg-primary text-light rounded shadow-sm p-2">Category - {{$category_name->name}} | From - {{$start_date}} | To - {{$end_date}}</p>
                @elseif($start_date != null && $end_date != null)
                    <p class=" fs-6 bg-primary text-light rounded shadow-sm p-2">Professional Title Usage by Seekers between {{$start_date}} and {{$end_date}}</p>
                @else
                    <p>You need to enter date format to show charts!</p>
                @endif
            </div>
            @if(count($data) != 0)
                <div class="col-12 shadow-sm d-flex justify-content-center align-items-center">
                    <div id="barchart" style="width:800px; height:400px;"></div>
                </div>
            @else
                <div class="col-12 d-flex justify-content-center align-items-center">
                    <div class=" bg-secondary p-2 text-white">
                        <i class="fa-solid fa-warning"></i>There is no information!
                    </div>
                </div>
            @endif
        </div>
        <div class="backBtn position-fixed " style="right: 30px;bottom:59px;width:50px;height:50px;">
            <button class="btn btn-dark my-3 text-center shadow  w-100 h-100 rounded-circle" style="line-height: 0;" onclick="history.back()">
                <i class="fa-solid fa-circle-left fs-4"></i>
            </button>
        </div>
    </div>
@endsection
