@extends('layouts.app')
@section('content')
    {{App::setLocale(Config::get("app.locale"))}}
    <div class="c-wrapper c-fixed-components">
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card text-white bg-primary">
                                    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="text-value-lg">{{$users}}</div>
                                            <div>{{__('translations.users')}}</div>
                                        </div>
                                    </div>
                                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                        <canvas class="chart" id="card-chart1" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card text-white bg-info">
                                    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="text-value-lg">{{$brokers}}</div>
                                            <div>{{__('translations.brokers')}}</div>
                                        </div>
                                    </div>
                                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                        <canvas class="chart" id="card-chart2" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card text-white bg-danger">
                                    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="text-value-lg">{{$agencies}}</div>
                                            <div>{{__('translations.agencies')}}</div>
                                        </div>
                                    </div>
                                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                        <canvas class="chart" id="card-chart4" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-->
                            <div class="col-sm-6 col-lg-3">
                                <div class="card text-white bg-warning">
                                    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="text-value-lg">{{$announcements}}</div>
                                            <div>{{__('translations.announcement')}}</div>
                                        </div>
                                    </div>
                                    <div class="c-chart-wrapper mt-3" style="height:70px;">
                                        <canvas class="chart" id="card-chart3" height="70"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row-->
                        <div class="card">
                                <div class="card ">
                                    <div class="card-block">
                                        <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                                    </div>
                                </div>
                            <div class="card-footer">
                                <div class="row text-center">
                                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                        <div class="text-muted">Visits</div><strong>2.703 Users (40%)</strong>
                                        <div class="progress progress-xs mt-2">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                        <div class="text-muted">Unique</div><strong>2.093 Users (20%)</strong>
                                        <div class="progress progress-xs mt-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                        <div class="text-muted">Pageviews</div><strong>78.706 Views (60%)</strong>
                                        <div class="progress progress-xs mt-2">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                                        <div class="text-muted">New Users</div><strong>1.123 Users (80%)</strong>
                                        <div class="progress progress-xs mt-2">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <input id="announcements0" type="text" value="{{$announcements_by_month[0]}}" hidden>
            <input id="announcements1" type="text" value="{{$announcements_by_month[1]}}" hidden>
            <input id="announcements2" type="text" value="{{$announcements_by_month[2]}}" hidden>
            <input id="announcements3" type="text" value="{{$announcements_by_month[3]}}" hidden>
            <input id="announcements4" type="text" value="{{$announcements_by_month[4]}}" hidden>
            <input id="announcements5" type="text" value="{{$announcements_by_month[5]}}" hidden>
            <input id="announcements6" type="text" value="{{$announcements_by_month[6]}}" hidden>
            <input id="announcements7" type="text" value="{{$announcements_by_month[7]}}" hidden>
            <input id="announcements8" type="text" value="{{$announcements_by_month[8]}}" hidden>
            <input id="announcements9" type="text" value="{{$announcements_by_month[9]}}" hidden>
            <input id="announcements10" type="text" value="{{$announcements_by_month[10]}}" hidden>
            <input id="announcements11" type="text" value="{{$announcements_by_month[11]}}" hidden>
            <input id="users0" type="text" value="{{$users_by_month[0]}}" hidden>
            <input id="users1" type="text" value="{{$users_by_month[1]}}" hidden>
            <input id="users2" type="text" value="{{$users_by_month[2]}}" hidden>
            <input id="users3" type="text" value="{{$users_by_month[3]}}" hidden>
            <input id="users4" type="text" value="{{$users_by_month[4]}}" hidden>
            <input id="users5" type="text" value="{{$users_by_month[5]}}" hidden>
            <input id="users6" type="text" value="{{$users_by_month[6]}}" hidden>
            <input id="users7" type="text" value="{{$users_by_month[7]}}" hidden>
            <input id="users8" type="text" value="{{$users_by_month[8]}}" hidden>
            <input id="users9" type="text" value="{{$users_by_month[9]}}" hidden>
            <input id="users10" type="text" value="{{$users_by_month[10]}}" hidden>
            <input id="users11" type="text" value="{{$users_by_month[11]}}" hidden>
</div>
        <script type="text/javascript">
            window.onload = function () {
                var announcements = []
                var users = []
                for(var i = 0; i < 12; i ++){
                    announcements[i] = document.getElementById("announcements" + i).value
                    users[i] = document.getElementById("users" + i).value
                }
                var chart = new CanvasJS.Chart("chartContainer", {
                    animationEnabled: true,
                    theme: "light2",
                    title:{
                        text: "Site Traffic"
                    },
                    axisX:{
                        valueFormatString: "DD MMM",
                        crosshair: {
                            enabled: true,
                            snapToDataPoint: true
                        }
                    },
                    axisY: {
                        title: "Number of Visits",
                        includeZero: true,
                        crosshair: {
                            enabled: true
                        }
                    },
                    toolTip:{
                        shared:true
                    },
                    legend:{
                        cursor:"pointer",
                        verticalAlign: "bottom",
                        horizontalAlign: "left",
                        dockInsidePlotArea: true,
                        itemclick: toogleDataSeries
                    },
                    data: [{
                        type: "line",
                        showInLegend: true,
                        name: "{{__('translations.announcements')}}",
                        markerType: "square",
                        xValueFormatString: "MMM, YYYY",
                        color: "#F08080",
                        dataPoints: [
                            { x: new Date(2021, new Date().getMonth()-10), y: Number(announcements[11])},
                            { x: new Date(2021, new Date().getMonth()-9), y: Number(announcements[10])},
                            { x: new Date(2021, new Date().getMonth()-8), y: Number(announcements[9])},
                            { x: new Date(2021, new Date().getMonth()-7), y: Number(announcements[8])},
                            { x: new Date(2021, new Date().getMonth()-6), y: Number(announcements[7])},
                            { x: new Date(2021, new Date().getMonth()-5), y: Number(announcements[6])},
                            { x: new Date(2021, new Date().getMonth()-4), y: Number(announcements[5])},
                            { x: new Date(2021, new Date().getMonth()-3), y: Number(announcements[4])},
                            { x: new Date(2021, new Date().getMonth()-2), y: Number(announcements[3])},
                            { x: new Date(2021, new Date().getMonth()-1), y: Number(announcements[2])},
                            { x: new Date(2021, new Date().getMonth()), y: Number(announcements[1])},
                            { x: new Date(2021, new Date().getMonth() +1), y: Number(announcements[0])}
                        ]
                    },
                        {
                            type: "line",
                            showInLegend: true,
                            name: "{{__('translations.users')}}",
                            lineDashType: "dash",
                            dataPoints: [
                                { x: new Date(2021, new Date().getMonth() - 10), y: Number(users[11])},
                                { x: new Date(2021, new Date().getMonth() - 9), y: Number(users[10])},
                                { x: new Date(2021, new Date().getMonth() - 8), y: Number(users[9])},
                                { x: new Date(2021, new Date().getMonth() - 7), y: Number(users[8])},
                                { x: new Date(2021, new Date().getMonth() - 6), y: Number(users[7])},
                                { x: new Date(2021, new Date().getMonth() - 5), y: Number(users[6])},
                                { x: new Date(2021, new Date().getMonth() - 4), y: Number(users[5])},
                                { x: new Date(2021, new Date().getMonth() - 3), y: Number(users[4])},
                                { x: new Date(2021, new Date().getMonth() - 2), y: Number(users[3])},
                                { x: new Date(2021, new Date().getMonth() - 1), y: Number(users[2])},
                                { x: new Date(2021, new Date().getMonth()), y: Number(users[1])},
                                { x: new Date(2021, new Date().getMonth() + 1), y:Number( users[0])},
                            ]
                        }]
                });
                chart.render();
                function toogleDataSeries(e){
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else{
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }

            }
        </script>
@endsection
