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
                <h3>{{ (isset($counts[0]->total)?$counts[0]->total:0) + (isset($counts[1]->total)?$counts[1]->total:0) + (isset($counts[2]->total)?$counts[2]->total:0)  }}</h3>
                <p>Total @lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="#" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $counts[0]->total??0 }}</h3>
                <p>Working @lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="#" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-gray">
            <div class="inner">
                <h3>{{ $counts[1]->total??0 }}</h3>
                <p>Pending @lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="#" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $counts[2]->total??0 }}</h3>
                <p>Not Working @lang('equicare.equipments')</p>
            </div>
            <div class="icon">
                <i class="fa fa-heartbeat"></i>
            </div>
            <a href="#" class="small-box-footer">@lang('equicare.more_info')
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#equipments" aria-controls="equipments" role="tab" data-toggle="tab">Equipment</a></li>
                <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Maintenance Calendar</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="equipments">
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table table-condensed table-bordered table-striped table-hover dataTable bottom-padding" id="data_table_equipment">
                            <thead class="thead-inverse">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th class="text-center">Short Name</th>
                                    <th class="text-center">Serial No</th>
                                    <th>Department</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Last Call Registered</th>
                                    <th class="text-center">Last Call Attended</th>
                                    <th class="text-center">Last Call Completed</th>
                                    <th class="text-center">Actions</th>
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
                <div role="tabpanel" class="tab-pane" id="profile">...</div>
                <div role="tabpanel" class="tab-pane" id="messages">...</div>
                <div role="tabpanel" class="tab-pane" id="settings">...</div>
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
                'print','copy', 'excel', 'pdf'
            ]
        });
    });
</script>
@endsection
@section('styles')

@endsection