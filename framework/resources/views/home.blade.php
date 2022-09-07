@extends('layouts.admin')
@section('body-title')
@lang('equicare.home')
@endsection
@section('title')
| @lang('equicare.dashboard')
@endsection
@section('breadcrumb')
<li class="active">@lang('equicare.dashboard')</li>
@endsection
@section('content')
<div class="row ">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ \App\Hospital::all()->count() }}</h3>
                <p>@lang('equicare.hospitals')</p>
            </div>
            <div class="icon">
                <i class="fa fa-hospital-o"></i>
            </div>
            <a href="{{ url('admin/hospitals') }}" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-maroon">
            <div class="inner">
                <h3>{{ \App\Equipment::all()->count() }}</h3>
                <p>@lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="{{ url('admin/equipments') }}" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ \App\CallEntry::where('call_type','breakdown')->count() }}</h3>
                <p>@lang('equicare.breakdown_maintenance')</p>
            </div>
            <div class="icon">
                <i class="fa fa-wrench"></i>
            </div>
            <a href="{{ url('admin/call/breakdown_maintenance') }}" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-olive">
            <div class="inner">
                <h3>{{ \App\CallEntry::where('call_type','preventive')->count() }}</h3>
                <p>@lang('equicare.preventive_maintenance')</p>
            </div>
            <div class="icon">
                <i class="fa fa-life-buoy"></i>
            </div>
            <a href="{{ url('admin/call/preventive_maintenance') }}" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ \App\Calibration::all()->count() }}</h3>
                <p>@lang('equicare.calibrations')</p>
            </div>
            <div class="icon">
                <i class="fa fa-balance-scale"></i>
            </div>
            <a href="{{ url('admin/calibration') }}" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ \App\Department::all()->count() }}</h3>
                <p>@lang('equicare.departments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <a href="{{ url('admin/departments') }}" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ \App\CallEntry::where('call_type', 'preventive')->get()->count() }}</h3>
                <p>@lang('equicare.preventive_reminder')</p>
            </div>
            <div class="icon">
                <i class="fa fa-calendar-check-o"></i>
            </div>
            <a href="{{ url('admin/reminder/preventive_maintenance') }}" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-gray">
            <div class="inner">
                <h3>{{ \App\Calibration::all()->count() }}</h3>
                <p>@lang('equicare.calibrations_reminder')</p>
            </div>
            <div class="icon">
                <i class="fa fa-clock-o"></i>
            </div>
            <a href="{{ url('admin/reminder/calibration') }}" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h4 class="box-title">@lang('equicare.calendar_title')</h4>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12" id="chart-container">


                <!-- <canvas id="myChart">
                    @lang('equicare.call_entries_chart_render')
                </canvas> -->

                <div id='custom-calendar'></div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- <script type="text/javascript" src="{{ asset('assets/bower_components/chart.js/Chart.bundle.min.js') }}"></script>
    <script type="text/javascript">
        $(function(){

            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($total_days_array) !!},
                    datasets: [
                    {
                        label: '{{__("equicare.breakdown_maintenance")}}',
                        data: {!! json_encode($breakdown) !!},
                        fill:false,
                        lineTension: 0.1,
                        borderColor: 'rgba(0,192,239,0.9)',
                    },
                    {
                        label: '{{__("equicare.preventive_maintenance")}}',
                        data: {!! json_encode($preventive) !!},
                        fill:false,
                        lineTension: 0.1,
                        borderColor:'rgba(57,204,204,0.7)'

                    },
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                stepSize:1,
                                suggestedMin: 0,
                                suggestedMax: 3
                            }
                        }],
                    }
                }
            });

        });
    </script> -->
<script type="text/javascript" src="{{ asset('assets/plugins/fullcalendar/main.min.js') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('custom-calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            displayEventTime: false,
            eventDisplay: 'block',
            timeZone: 'UTC',
            initialView: 'dayGridMonth',
            businessHours: true,
            handleWindowResize: true,
            dayMaxEvents: true,
            events: "{!! url('admin/calendar') !!}",
            headerToolbar: {
                left: 'dayGridMonth,timeGridWeek,timeGridDay',
                center: 'title',
                right: 'prevYear,prev,next,nextYear'
            },
        });
        calendar.render();
    });
</script>
@endsection
@section('styles')
<style type="text/css">
    .bg-gray-active:hover {
        color: #000;
    }
</style>
@endsection