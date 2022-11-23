@extends('layouts.admin')
@section('body-title')
@lang('equicare.call_entries')
@endsection
@section('title')
| @lang('equicare.breakdown_maintenance_call_entry')
@endsection
@section('breadcrumb')
<li class="active">@lang('equicare.breakdown_maintenance')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">@lang('equicare.breakdown_maintenance')
					@can('Create Breakdown Maintenance')
					<a href="{{ route('breakdown_maintenance.create') }}" class="btn btn-primary btn-flat">@lang('equicare.add_new')</a>
					@endcan
				</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive overflow_x_unset">
					<table id="data_table" class="table table-hover table-bordered table-striped table-lg">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th> @lang('equicare.equipment_name') </th>
								<th> @lang('equicare.call_handle') </th>
								<th> @lang('equicare.working_status') </th>
								<th> @lang('equicare.serial_number') </th>
								<th> @lang('equicare.report_number') </th>
								<th> @lang('equicare.call_registration_date_time')</th>
								<th> @lang('equicare.attended_by') </th>
								<th> @lang('equicare.first_attended_on') </th>
								<th> @lang('equicare.completed_on') </th>
								<th> @lang('equicare.action') </th>
							</tr>
						</thead>
						<tbody>
							@php $count=0; @endphp
							@if (isset($b_maintenance))
							@foreach ($b_maintenance as $breakdown)
							@php $count++; @endphp
							<tr>
								<td class="text-center"> {{ $count }} </td>
								<td> {{ $breakdown->equipment->name.' ('.$breakdown->equipment->short_name.') ('.$breakdown->equipment->model.')'?? '-' }} </td>
								<td> {{ $breakdown->call_handle?ucfirst($breakdown->call_handle): '-' }} </td>
								<td> 
									@php
										switch ($breakdown->working_status) {
											case 'working':
												echo '<label class="label label-success">'.ucwords($breakdown->working_status).'</label>';
												break;
											case 'not working':
												echo '<label class="label label-danger">'.ucwords($breakdown->working_status).'</label>';
												break;
											default:
												echo '<label class="label label-default">'.ucwords($breakdown->working_status).'</label>';
												break;
										}
									@endphp
								</td>
								<td> {{ $breakdown->equipment->sr_no?? '-' }} </td>
								<td> {{ $breakdown->report_no?sprintf("%04d",$breakdown->report_no):'-'  }} </td>
								<td>
									{{ $breakdown->call_register_date_time? date('Y-m-d h:i A', strtotime($breakdown->call_register_date_time)) : '-' }}
								</td>
								<td>{{$breakdown->user_attended?$breakdown->user_attended_fn->name:'-'}}{{$breakdown->user_attended_2?' & '.$breakdown->user_attended_2_fn->name:''}}</td>
								<td>
									{{$breakdown->user_attended?date('Y-m-d H:i A',strtotime($breakdown->call_attend_date_time)):'-'}}
								</td>
								<td>
									{{$breakdown->call_complete_date_time?date('Y-m-d H:i A',strtotime($breakdown->call_complete_date_time)):'-'}}
								</td>
								<td class="text-center">
									<div class="btn-group">
										<button type="button" class="btn btn-flat btn-primary dropdown-toggle btn-sm"
											data-toggle="dropdown" aria-expanded="true">
											<span class="fa fa-cogs"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>

										<ul class="dropdown-menu custom" role="menu">
											@can('Edit Breakdown Maintenance')
											<li>
												<a href="{{ route('breakdown_maintenance.edit',$breakdown->id) }}" class=""
													title="@lang('equicare.edit')"><i class="fa fa-edit purple-color" ></i> @lang('equicare.edit') </a>
											</li>
											@endcan
											<li>
												@if(is_null($breakdown->call_attend_date_time))
												<a href="#attend_modal" title="@lang('equicare.attend_call')" class="attend_btn"
													data-status="{{ $breakdown->working_status  }}" data-id="{{ $breakdown->id }}">
													<i class="fa fa-list-alt yellow-color"></i>
													@lang('equicare.attend_call')
												</a>
												@endif
											</li>
											@if(!is_null($breakdown->call_attend_date_time) && is_null($breakdown->call_complete_date_time))
											<li>
												<a href="#call_complete_modal" data-target="#call_complete_modal"
													data-toggle="modal" title="@lang('equicare.call_complete')" class="call_complete_btn"
													data-status="{{ $breakdown->working_status  }}" data-id="{{ $breakdown->id }}">
													<i class="fa fa-thumbs-o-up green-color"></i>
													@lang('equicare.call_complete')
												</a>
											</li>
											@endif
											@can('Delete Breakdown Maintenance')
											<li>
												<a class="" href="javascript:document.getElementById('form1-{{$breakdown->id}}').submit();"
													onclick="return confirm('@lang('equicare.are_you_sure')')" title="@lang('equicare.delete')"><span
														class="fa fa-trash-o red-color" aria-hidden="true"></span>
														@lang('equicare.delete')
												</a>

											</li>
											@endcan
										</ul>
									</div>
									{!! Form::open(['url' =>
									'admin/call/breakdown_maintenance/'.$breakdown->id,'method'=>'DELETE','id'=>'form1-'.$breakdown->id,
									'class'=>'form-horizontal'])
									!!}
									<input type="hidden" id="id" name="id" value="{{ $breakdown->id }}">
									{!! Form::close() !!}
								</td>
							</tr>
							@endforeach
							@endif
						</tbody>
						<tfoot>
							<tr>
								<th class="text-center">#</th>
								<th> @lang('equicare.equipment_name') </th>
								<th> @lang('equicare.call_handle') </th>
								<th> @lang('equicare.working_status') </th>
								<th> @lang('equicare.serial_number') </th>
								<th> @lang('equicare.report_number') </th>
								<th> @lang('equicare.call_registration_date_time')</th>
								<th> @lang('equicare.attended_by') </th>
								<th> @lang('equicare.first_attended_on') </th>
								<th> @lang('equicare.completed_on') </th>
								<th> @lang('equicare.action') </th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
{{-- Attend call modal ======================================= --}}
<div class="modal fade" id="attend_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			{!! Form::open([
			'action'=>'BreakdownController@attend_call',
			'method' => 'POST',
			'class' => 'attend_call_form',
			'id' => 'attend_call_form'
			]) !!}
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">@lang('equicare.attend_call')</h4>
			</div>
			<div class="modal-body">
				@if (count($errors->attend_call) > 0)
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger">
							<ul class=" mb-0">
								@foreach ($errors->attend_call->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				@endif
				<div class="row">
					<div class="form-group col-md-6">
						{!! Form::label('call_attend_date_time',__('equicare.call_attend_date_time')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::text('call_attend_date_time',null,['class'=>'form-control call_attend_date_time']) !!}
						{{ Form::hidden('b_id',null,['class'=>'b_id']) }}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="user_attended">@lang('equicare.user_attended') 1</label>
						<span class="text-red">&nbsp;*</span>
						{!! Form::select('user_attended',$users,Auth::user()->id??null,['placeholder'=>'select user','class'=>'form-control
						user_attended']) !!}
					</div>
					<div class="form-group col-md-6">
						<label for="user_attended_2">@lang('equicare.user_attended') 2</label>
						{!! Form::select('user_attended_2',$users,null,['placeholder'=>'select user','class'=>'form-control
						user_attended_2']) !!}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						{!! Form::label('service_rendered',__('equicare.service_rendered')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::select('service_rendered',$services??[],null,['placeholder'=>__('equicare.select_option'),'class' => 'form-control test service_rendered_select2']) !!}
					</div>
					<div class="form-group col-md-6">
						<label>@lang('equicare.working_status')<span class="text-red">&nbsp;*</span></label>
						{!! Form::select('working_status',[
						'working' => __("equicare.working"),
						'not working' => __("equicare.not_working"),
						'pending' => __("equicare.pending")
						],null,['placeholder' => '--select--','class' => 'form-control test working_status']) !!}
					</div>
					
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						{!! Form::label('remarks',__('equicare.remarks')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::textarea('remarks', null, ['class'=>'form-control remarks','rows'=>4]) !!}
					</div>
					<input type="hidden" name="id" class="id" value="">
				</div>

			</div>
			<div class="modal-footer">
				{!! Form::submit(__('equicare.submit'),['class'=>'btn btn-primary submit_attend']) !!}
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('equicare.close')</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
{{-- call complete modal======================================= --}}
<div class="modal fade" id="call_complete_modal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			{!! Form::open(['method'=>'post','action'=>'BreakdownController@call_complete','files'=>true]) !!}
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">@lang('equicare.complete_call')</h4>
			</div>
			<div class="modal-body">
				@if (count($errors->complete_call) > 0)
				<div class="row">
					<div class="col-md-12">
						<div class="alert alert-danger">
							<ul class=" mb-0">
								@foreach ($errors->complete_call->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				@endif
				<div class="row">
					<div class="form-group col-md-6">
						{!! Form::label('call_complete_date_time',__('equicare.call_complete_date_time')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::text('call_complete_date_time',null,['class'=>'form-control call_complete_date_time']) !!}
					</div>
					<div class="form-group col-md-6">
						{!! Form::label('service_rendered',__('equicare.service_rendered')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::select('service_rendered',$services??[],null,['placeholder'=>__('equicare.select_option'),'class' => 'form-control test service_rendered_select2']) !!}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label>@lang('equicare.working_status')<span class="text-red">&nbsp;*</span></label>
						{!! Form::select('working_status',[
						'working' => __("equicare.working"),
						'not working' => __("equicare.not_working"),
						'pending' => __("equicare.pending")
						],null,['placeholder' => '--select--','class' => 'form-control test working_status']) !!}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						{!! Form::label('remarks',__('equicare.remarks')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::textarea('remarks', null, ['class'=>'form-control remarks','rows'=>4]) !!}
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						{!! Form::label('sign_of_engineer', __('equicare.sign_of_engineer')) !!}
						{!! Form::file('sign_of_engineer',[
						'class'=>'form-control sign_of_engineer',
						'id' => 'sign_of_engineer'
						]) !!}
						{{ Form::hidden('b_id',null,['class'=>'b_id']) }}
						<a class="view_image_sign_of_engineer"
							href="{{ isset($breakdown_c) && $breakdown_c->sign_of_engineer !=null?url('uploads/',$breakdown_c->sign_of_engineer) :'' }}"
							target="_blank">
							view
						</a>
					</div>
					<div class="form-group col-md-6">
						{!! Form::label('sign_stamp_of_incharge', __('equicare.sign_stamp_of_incharge')) !!}
						{!! Form::file('sign_stamp_of_incharge',[
						'class'=>'form-control sign_stamp_of_incharge',
						'id' => 'sign_stamp_of_incharge'
						]) !!}
						<a class="view_image_sign_stamp_of_incharge" href="" target="_blank">
							view
						</a>
					</div>
					<input type="hidden" name="id" class="id" value="">
				</div>

			</div>
			<div class="modal-footer">
				{!! Form::submit(__('equicare.submit'),['class'=>'btn btn-primary submit_call']) !!}
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('equicare.close')</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/datetimepicker.js') }}" type="text/javascript"></script>
<script type="text/javascript">

</script>
<script type="text/javascript">
	$(document).ready(function(){

		$('.service_rendered_select2').select2({
			placeholder: '{{__("equicare.select_option")}}',
			allowClear: true,
			tags: true,
		});

		@if(count($errors->attend_call) > 0)
			$('#attend_modal').modal('show');
		@endif

		@if(count($errors->complete_call) > 0)
			$('#call_complete_modal').modal('show');
		@endif

		$('.call_complete_date_time').datetimepicker({
			format: 'Y-MM-D hh:mm A',
		});

	});

	$('.attend_btn').on('click',function(){

		var id = $(this).attr('data-id');

		$('.test').val($(this).attr('data-status'));

		$.ajax({
			url:'{{ url('admin/call/breakdown_maintenance/attend') }}'+'/'+id ,
			method: 'get',
			data: {
				id: id,
			},
			success:function(response){

				$('.call_attend_date_time').datetimepicker({
					format: 'Y-MM-D hh:mm A',
				});

				$('.call_attend_date_time').datetimepicker('destroy');

				$('.call_attend_date_time').val(response.b_m.call_attend_date_time);

				$('.call_attend_date_time').datetimepicker({
					format: 'Y-MM-D hh:mm A',
				});

				if (response.b_m.user_attended !== null){
					$('.user_attended').val(response.b_m.user_attended);
				}

				$(".service_rendered_select2").val(response.b_m.service_rendered).trigger('change');

				$('.remarks').text(response.b_m.remarks);

				$('.working_status').val(response.b_m.working_status);

				$('.b_id').val(response.b_m.id);

				$('#attend_modal').modal('show');

			}
		});

		$('.id').val($(this).attr('data-id'));

	});

	$('.call_complete_btn').on('click',function(){

		var id = $(this).attr('data-id');

		$('.test').val($(this).attr('data-status'));

		$.ajax({
			url:'{{ url('admin/call/breakdown_maintenance/call_complete') }}'+'/'+id ,
			method: 'get',
			data: {
				id: id,
			},
			success:function(response){

				$('.call_complete_date_time').datetimepicker({
					format: 'Y-MM-D hh:mm A',
				});

				$('.call_complete_date_time').datetimepicker('destroy');

				$('.call_complete_date_time').val(response.b_m.call_complete_date_time);

				$('.call_complete_date_time').datetimepicker({
					format: 'Y-MM-D hh:mm A',
				});

				$(".service_rendered_select2").val(response.b_m.service_rendered).trigger('change');

				$('.remarks').text(response.b_m.remarks);

				$('.working_status').val(response.b_m.working_status);

				$('.b_id').val(response.b_m.id);

				$('.view_image_sign_stamp_of_incharge').attr('href',"{{ url('uploads') }}"+'/'+response.b_m.sign_stamp_of_incharge);

				if(response.b_m.sign_stamp_of_incharge != null){
					$('.view_image_sign_stamp_of_incharge').show();
				}else{
					$('.view_image_sign_stamp_of_incharge').hide();
				}

				$('.view_image_sign_of_engineer').attr('href',"{{ url('uploads') }}"+'/'+response.b_m.sign_of_engineer);

				if(response.b_m.sign_of_engineer != null){
					$('.view_image_sign_of_engineer').show();
				}else{
					$('.view_image_sign_of_engineer').hide();
				}

			}
		});
	});

</script>
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
</script>
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
<style type="text/css">
	.select2-container {
		display: block;
	}
</style>
@endsection