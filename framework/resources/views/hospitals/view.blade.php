@extends('layouts.admin')
@section('body-title')
{{ $hospital->name }} - Statistics &amp; @lang('equicare.reports')
@endsection
@section('title')
| {{ $hospital->name }}
@endsection
@section('breadcrumb')
<!-- <li class="active">@lang('equicare.hospitals')</li> -->
@endsection
@section('content')
<div class="row ">
    <div class="col-md-3">
        <div class="small-box bg-purple">
            <div class="inner">
                <h3>{{ $counts->total }}</h3>
                <p>Total @lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="#" class="small-box-footer">
                &nbsp;
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $counts->working }}</h3>
                <p>Working @lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="#" class="small-box-footer">
                &nbsp;
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-gray">
            <div class="inner">
                <h3>{{ $counts->pending }}</h3>
                <p>Pending @lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="#" class="small-box-footer">
                &nbsp;
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $counts->not_working }}</h3>
                <p>Not Working @lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="#" class="small-box-footer">
                &nbsp;
            </a>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#equipments" aria-controls="equipments" role="tab" data-toggle="tab">@lang('equicare.equipments')</a></li>
                <li role="presentation"><a href="#pm_maintenance" aria-controls="pm_maintenance" role="tab" data-toggle="tab">@lang('equicare.preventive_maintenance') Calls</a></li>
                <li role="presentation"><a href="#b_maintenance" aria-controls="b_maintenance" role="tab" data-toggle="tab">@lang('equicare.breakdown_maintenance') Calls</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="equipments">
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table table-condensed table-bordered table-striped table-hover dataTable bottom-padding" id="data_table_equipment">
                            <thead class="thead-inverse">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">@lang('equicare.name')</th>
                                    <th class="text-center">@lang('equicare.short_name')</th>
                                    <th class="text-center">@lang('equicare.serial_no')</th>
                                    <th class="text-center">@lang('equicare.department')</th>
                                    <th class="text-center">@lang('equicare.working_status')</th>
                                    <th class="text-center">@lang('equicare.call_register_date_time')</th>
                                    <th class="text-center">@lang('equicare.call_attend_date_time')</th>
                                    <th class="text-center">@lang('equicare.call_complete_date_time')</th>
                                    <th class="text-center">@lang('equicare.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1 @endphp
                                @foreach ($equipments as $equipment)
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>{{ $equipment->name }}</td>
                                    <td class="text-center">{{ $equipment->short_name }}</td>
                                    <td class="text-center">{{ $equipment->sr_no }}</td>
                                    <td>{{ $equipment->department }}</td>
                                    <td class="text-center">
                                        @php
                                        switch ($equipment->working_status) {
                                        case 'working':
                                        echo '<label class="label label-success">'.ucwords($equipment->working_status).'</label>';
                                        break;
                                        case 'not working':
                                        echo '<label class="label label-danger">'.ucwords($equipment->working_status).'</label>';
                                        break;
                                        default:
                                        echo '<label class="label label-default">'.ucwords($equipment->working_status).'</label>';
                                        break;
                                        }
                                        @endphp
                                    </td>
                                    <td class="text-center">{{ $equipment->call_register_date_time?date("d M Y",strtotime($equipment->call_register_date_time)):'-' }}</td>
                                    <td class="text-center">{{ $equipment->call_attend_date_time?date("d M Y",strtotime($equipment->call_attend_date_time)):'-' }}</td>
                                    <td class="text-center">{{ $equipment->call_complete_date_time?date("d M Y",strtotime($equipment->call_complete_date_time)):'-' }}</td>
                                    <td class="text-center">
                                        <a target="_blank" href="{{ route('equipments.history',$equipment->id) }}" class="btn bg-olive btn-sm btn-flat marginbottom" title="@lang('equicare.history')"><i class="fa fa-history"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="pm_maintenance">
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table table-condensed table-bordered table-striped table-hover dataTable bottom-padding" id="data_table_preventive">
                            <thead class="thead-inverse">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">@lang('equicare.call_type')</th>
                                    <th class="text-center">@lang('equicare.working_status')</th>
                                    <th class="text-center">@lang('equicare.due_date')</th>
                                    <th class="text-center">@lang('equicare.call_register_date_time')</th>
                                    <th class="text-center">@lang('equicare.call_attend_date_time')</th>
                                    <th class="text-center">@lang('equicare.call_complete_date_time')</th>
                                    <th class="text-center">@lang('equicare.user_attended')</th>
                                    <th class="text-center">@lang('equicare.service_rendered')</th>
                                    <th class="text-center">@lang('equicare.nature_of_problem')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1 @endphp
                                @foreach ($calls as $call)
                                @if($call->call_type == 'preventive')
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>@lang('equicare.preventive_maintenance')</td>
                                    <td class="text-center">
                                        @php
                                        switch ($call->working_status) {
                                        case 'working':
                                        echo '<label class="label label-success">'.ucwords($call->working_status).'</label>';
                                        break;
                                        case 'not working':
                                        echo '<label class="label label-danger">'.ucwords($call->working_status).'</label>';
                                        break;
                                        default:
                                        echo '<label class="label label-default">'.ucwords($call->working_status).'</label>';
                                        break;
                                        }
                                        @endphp
                                    </td>
                                    <td class="text-center">{{ $call->next_due_date?date("d M Y",strtotime($call->next_due_date)):'-' }}</td>
                                    <td class="text-center">{{ $call->call_register_date_time?date("d M Y",strtotime($call->call_register_date_time)):'-' }}</td>
                                    <td class="text-center">{{ $call->call_attend_date_time?date("d M Y",strtotime($call->call_attend_date_time)):'-' }}</td>
                                    <td class="text-center">{{ $call->call_complete_date_time?date("d M Y",strtotime($call->call_complete_date_time)):'-' }}</td>
                                    <td class="text-center">
                                        {{ $call->user_attended ? optional($call->user_attended_fn)->name : '-' }}
                                        {{ $call->user_attended_2 ? ' & ' . optional($call->user_attended_2_fn)->name : '' }}
                                    </td>

                                    <td class="text-center">{{ $call->service_rendered }}</td>
                                    <td class="text-center">{{ $call->nature_of_problem }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="b_maintenance">
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table table-condensed table-bordered table-striped table-hover dataTable bottom-padding" id="data_table_breakdown">
                            <thead class="thead-inverse">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">@lang('equicare.call_type')</th>
                                    <th class="text-center">@lang('equicare.working_status')</th>
                                    <th class="text-center">@lang('equicare.call_register_date_time')</th>
                                    <th class="text-center">@lang('equicare.call_attend_date_time')</th>
                                    <th class="text-center">@lang('equicare.call_complete_date_time')</th>
                                    <th class="text-center">@lang('equicare.user_attended')</th>
                                    <th class="text-center">@lang('equicare.service_rendered')</th>
                                    <th class="text-center">@lang('equicare.nature_of_problem')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1 @endphp
                                @foreach ($calls as $call)
                                @if($call->call_type == 'breakdown')
                                <tr>
                                    <td class="text-center">{{ $i++ }}</td>
                                    <td>@lang('equicare.breakdown_maintenance')</td>
                                    <td class="text-center">
                                        @php
                                        switch ($call->working_status) {
                                        case 'working':
                                        echo '<label class="label label-success">'.ucwords($call->working_status).'</label>';
                                        break;
                                        case 'not working':
                                        echo '<label class="label label-danger">'.ucwords($call->working_status).'</label>';
                                        break;
                                        default:
                                        echo '<label class="label label-default">'.ucwords($call->working_status).'</label>';
                                        break;
                                        }
                                        @endphp
                                    </td>
                                    <td class="text-center">{{ $call->call_register_date_time?date("d M Y",strtotime($call->call_register_date_time)):'-' }}</td>
                                    <td class="text-center">{{ $call->call_attend_date_time?date("d M Y",strtotime($call->call_attend_date_time)):'-' }}</td>
                                    <td class="text-center">{{ $call->call_complete_date_time?date("d M Y",strtotime($call->call_complete_date_time)):'-' }}</td>
                                    <td class="text-center">
                                        {{ $call->user_attended ? optional($call->user_attended_fn)->name : '-' }}
                                        {{ $call->user_attended_2 ? ' & ' . optional($call->user_attended_2_fn)->name : '' }}
                                    </td>

                                    <td class="text-center">{{ $call->service_rendered }}</td>
                                    <td class="text-center">{{ $call->nature_of_problem }}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#data_table_equipment').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print', 'copy', 'excel', 'pdf'
            ]
        });
        $('#data_table_preventive').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print', 'copy', 'excel', 'pdf'
            ]
        });
        $('#data_table_breakdown').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print', 'copy', 'excel', 'pdf'
            ]
        });
    });
</script>
@endsection
@section('styles')

@endsection