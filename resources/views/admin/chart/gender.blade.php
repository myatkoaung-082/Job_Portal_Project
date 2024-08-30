@extends('admin.layouts.main')

@section('title')
    Gender Pie Chart
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row text-center shadow-sm mb-2">
            <div class="col-12"><h3>Gender Ratio of Seeker in Next-Gen Job Matching</h3></div>
        </div>
        <div class="row">
            <div class="col-12 shadow-sm d-flex justify-content-center align-items-center">
                <div id="piechart" style="width: 600px; height: 350px;"></div>
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
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawCharts);

    async function drawCharts() {
        await piechart();
        await columnchart();
    }

    async function piechart() {
        fetch('/analysis/ageData')
            .then(response => response.json())
            .then(data => {
                var chartData = [
                    ['Gender', 'Total']
                ];
                chartData = chartData.concat(data);

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    title: 'Seekers Gender Ratio'
                };

                const barchart = new google.visualization.PieChart(document.getElementById('piechart'));

                barchart.draw(dataTable, options);
            });
    }
    setInterval(piechart, 5000); // Refresh chart every 5 seconds

    async function columnchart() {
        fetch('/analysis/seekerdata')
            .then(response => response.json())
            .then(data => {
                var chartData = [
                    ['professional_title_name', 'total']
                ];
                data.forEach(item => {
                    chartData.push([item.professional_title_name, item.total]);
                });

                const dataTable = google.visualization.arrayToDataTable(chartData);
                // var view = new google.visualization.DataView(data);

                var options = {
                    title: "Professional Title Usage of Seekers",
                    hAxis: {
                        title: 'Professional_Title'
                    },
                    vAxis: {
                        title: 'Total'
                    }
                };
                var chart = new google.visualization.ColumnChart(document.getElementById("barchart"));
                chart.draw(dataTable, options);
            })
    }
    setInterval(columnchart, 5000);
</script>
@endsection