@extends('layouts.admin')
@section('body-title')
@lang('equicare.report_activity')
@endsection
@section('title')
| @lang('equicare.report_activity')
@endsection
@section('breadcrumb')
<li class="active">@lang('equicare.report')</li>
<li class="active">@lang('equicare.report_activity')</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">@lang('equicare.generate_report')</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['url'=>'admin/reports/activity_report','method'=>'POST']) !!}
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							{!! Form::label('hospital_id',__('equicare.hospital')) !!}
							<span class="text-red">&nbsp;*</span>
							{!! Form::select('hospital_id',$hospitals??[],null,['placeholder'=>__('equicare.select_option'),'class' => 'form-control select2 hospital', 'required' => 'true']) !!}
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							{!! Form::label('department_id',__('equicare.department')) !!}
							{!! Form::select('department_id',$departments??[],null,['placeholder'=>__('equicare.select_option'),'class' => 'form-control select2 department']) !!}
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							{!! Form::label('from_date',__('equicare.from_date')) !!}
							<span class="text-red">&nbsp;*</span>
							{!! Form::text('from_date',$from_date??null,['class' => 'date-picker form-control', 'required' => 'true','placeholder'=>__('equicare.select_from_date')]) !!}
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							{!! Form::label('to_date',__('equicare.to_date')) !!}
							<span class="text-red">&nbsp;*</span>
							{!! Form::text('to_date',$to_date??null,['class' => 'date-picker form-control', 'required' => 'true','placeholder'=>__('equicare.select_to_date')]) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3">
						<input type="submit" value="@lang('equicare.generate')" class="btn btn-primary btn-flat" />
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">@lang('equicare.report_activity') Table</h4>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-hover" id="datatable" width="100%">
								<thead>
									<tr>
										<th class="text-center">NO.</th>
										<th class="text-center">HOSPITAL</th>
										<th class="text-center">EQUIPMENT</th>
										<th class="text-center">DEPT/UNIT</th>
										<th class="text-center">MODEL</th>
										<th class="text-center">S. NUMBER</th>
										<th class="text-center">SERVICE</th>
										<th class="text-center">ACTION TAKEN</th>
										<th class="text-center">REMARKS</th>
										<th class="text-center">MAINTENANCE DATE</th>
									</tr>
								</thead>
								<tbody>
									@php
									$i = 1;
									@endphp
									@foreach($calls as $call)
									<tr>
										<td class="text-center">{{ $i++ }}</td>
										<td>{{ $call->equipment->hospital->name }}</td>
										<td>{{ $call->equipment->name }}</td>
										<td>{{ $call->equipment->get_department->name }}</td>
										<td class="text-center">{{ $call->equipment->model }}</td>
										<td class="text-center">{{ $call->equipment->model }}</td>
										<td class="text-center">
											@php
											switch ($call->call_type) {
											case 'breakdown':
											@endphp
											<label class="label label-primary">@lang('equicare.breakdown')</label>
											@php
											break;
											default:
											@endphp
											<label class="label label-success">@lang('equicare.preventive')</label>
											@php
											break;
											}
											@endphp
										</td>
										<td>{{ $call->remarks }}</td>
										<td class="text-center">Complete</td>
										<td class="text-center">{{ $call->call_complete_date_time }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/datetimepicker.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {

		var table = $('#datatable').DataTable({
			dom: 'QBfrtip',
			responsive: true,
			buttons: [
				'pageLength', 'print', 'copy', 'excel', {
					extend: 'pdfHtml5',
					orientation: 'landscape',
					pageSize: 'A4'
				}
			],
			language: {
				searchBuilder: {
					title: {
						0: '',
						_: 'Filters (%d)'
					},
					add: 'Add Filter',
					data: 'Select Column',
					value: 'Select Option',
					condition: 'Select Comparator'
				}
			},
		});

		$('.select2').select2({
			allowClear: true,
			tags: true
		});

		$('.hospital').on('change', function(e) {
			$('.department').val(null).trigger('change');
			var hospital_id = $(this).val();
			$('.department').select2({
				allowClear: true,
				tags: true,
				ajax: {
					url: "{{url('department_equipment')}}/" + hospital_id,
					dataType: 'json'
				}
			});
		});

		$('.date-picker').datetimepicker({
			format: 'Y-MM-DD'
		});

	});
</script>
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
<style type="text/css">
	.select2-container {
		width: 100% !important;
		display: block !important;
	}

	.dtsb-titleRow {
		display: none !important;
	}

	.dt-buttons {
		display: block !important;
	}
</style>
@endsection