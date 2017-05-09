@extends('layouts.apps')
@section('content')

<div class="small-header transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="pull-right" id="hbreadcrumb">
                <ol class="hbreadcrumb breadcrumb">
                    <li> Dashboard </li>
                    <li class="active">
                        <span> Dashboard</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs"> Dashboard </h2>
        </div>
    </div>
</div>
<div class="content animate-panel">
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <div id="dailySheet"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-body">
                    <div id="yearlySheet"></div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! HTML::script('admintheme/vendor/jquery/dist/jquery.min.js') !!}
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script type="text/javascript">
    $(function(){
        $('#dailySheet').highcharts({
            chart: {
                type: 'column'
            },

            title: {
                text: 'Project & Blueprint Analysis (Last 15 Days)'
            },
            xAxis: {
                categories: [
                    @foreach($date_array as $date)
                        '{{$date}}',
                    @endforeach
                ]
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Number of Projects/Blueprints'
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + this.x + '</b><br/>' +
                        this.series.name + ': ' + this.y + '<br/>' +
                        'Total: ' + this.point.stackTotal;
                }
            },

            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            credits: {
                enabled: false
            },
            series: {!! $dailyChartofUser !!}
        });
        $('#yearlySheet').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Yearly Analysis'
            },
            xAxis: {
                categories: [
                    'January','February','March','April','May','June','July','August','September','October','November','December']
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Counts'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            credits: {
                enabled: false
              },
            colors: [
               '#2f7ed8',
               '#0d233a',
               '#910000',
               '#91e8e1'
            ],
            series: {!! $yearlyChartofUser !!}
        });
    });
</script>

@endsection