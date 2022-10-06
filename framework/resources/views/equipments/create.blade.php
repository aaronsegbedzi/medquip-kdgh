@extends('layouts.admin')
@section('body-title')
@lang('equicare.equipments')
@endsection
@section('title')
| @lang('equicare.equipments')
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('admin/equipments') }}">@lang('equicare.equipments') </a></li>
<li class="active">@lang('equicare.create')</li>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title">@lang('equicare.create_equipments')</h4>
			</div>
			<div class="box-body ">
				@include ('errors.list')
				<form class="form" method="post" action="{{ route('equipments.store') }}">
					{{ csrf_field() }}
					{{ method_field('POST') }}
					<div class="row">
						<div class="form-group col-md-6">
							<label for="name"> @lang('equicare.name')<span class="text-red">&nbsp;*</span></label>
							<input type="text" name="name" class="form-control" value="{{ old('name') }}" />
						</div>
						<div class="form-group col-md-6">
							<label for="short_name"> @lang('equicare.short_name_eq')<span class="text-red">&nbsp;*</span></label>
							<input type="text" name="short_name" class="form-control" value="{{ old('short_name') }}" />
						</div>
						<div class="form-group col-md-6">
							<label for="company"> @lang('equicare.company')<span class="text-red">&nbsp;*</span></label>
							<input type="text" name="company" class="form-control" value="{{ old('company') }}" />
						</div>
						<div class="form-group col-md-6">
							<label for="model"> @lang('equicare.model')<span class="text-red">&nbsp;*</span></label>
							<input type="text" name="model" class="form-control" value="{{ old('model') }}" />
						</div>
						<div class="form-group col-md-6">
							<label for="sr_no"> @lang('equicare.serial_number')<span class="text-red">&nbsp;*</span></label>
							<input type="text" name="sr_no" class="form-control" value="{{ old('sr_no') }}" />
						</div>
						<div class="form-group col-md-6">
							{!! Form::label('hospital_id',__('equicare.hospital')) !!}
							<span class="text-red">&nbsp;*</span>
							{!! Form::select('hospital_id',$hospitals??[],null,['placeholder'=>__('equicare.select_option'),'class' => 'form-control select2 hospital']) !!}
						</div>
						<div class="form-group col-md-6">
							{!! Form::label('department',__('equicare.department')) !!}
							<span class="text-red">&nbsp;*</span>
							{!! Form::select('department',$departments??[],null,['placeholder'=>__('equicare.select_option'),'class' => 'form-control select2 department']) !!}
						</div>
						<div class="form-group col-md-6">
							<label for="date_of_purchase"> @lang('equicare.purchase_date') </label>
							<div class="input-group">

								<input type="text" id="date_of_purchase" name="date_of_purchase" class="form-control" value="{{ old('date_of_purchase') }}" />
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="order_date"> @lang('equicare.order_date') </label>
							<div class="input-group">

								<input type="text" id="order_date" name="order_date" class="form-control" value="{{ old('order_date') }}" />
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="date_of_installation"> @lang('equicare.installation_date') </label>
							<div class="input-group">

								<input type="text" id="date_of_installation" name="date_of_installation" class="form-control" value="{{ old('date_of_installation') }}" />
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="warranty_due_date"> @lang('equicare.warranty_due_date') </label>
							<div class="input-group">

								<input type="text" id="warranty_due_date" name="warranty_due_date" class="form-control" value="{{ old('warranty_due_date') }}" />
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="service_engineer_no"> @lang('equicare.service_engineer_number')<span class="text-red">&nbsp;*</span></label>
							<input type="text" name="service_engineer_no" class="form-control" value="{{ old('service_engineer_no') }}" />
						</div>
						<div class="form-group col-md-6">
							<label> @lang('equicare.critical') </label><br />
							<label>
								<input type="radio" value="1" name="is_critical">
								@lang('equicare.yes') </label> &nbsp;
							<label>
								<input type="radio" value="0" name="is_critical">
								@lang('equicare.no')
							</label>
						</div>
						<div class="form-group col-md-6">
							<label for="notes"> @lang('equicare.notes') </label>
							<textarea rows="2" name="notes" class="form-control">{{ old('notes') }}</textarea>
						</div>
						<div class="form-group col-md-12">
							<input type="submit" value="@lang('equicare.submit')" class="btn btn-primary btn-flat" />
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('#date_of_purchase').datepicker({
			'format': 'yyyy-mm-dd',
			'todayHighlight': true,
		});
		$('#order_date').datepicker({
			'format': 'yyyy-mm-dd',
			'todayHighlight': true,
		});
		$('#date_of_installation').datepicker({
			'format': 'yyyy-mm-dd',
			'todayHighlight': true,
		});
		$('#warranty_due_date').datepicker({
			'format': 'yyyy-mm-dd',
			'todayHighlight': true,
		});
		$('.select2').select2({
			placeholder: '{{__("equicare.select_option")}}',
			allowClear: true,
			tags: true
		});

		$('.hospital').on('change', function(e) {
			$('.department').val(null).trigger('change');
			var hospital_id = $(this).val();
			$('.department').select2({
				placeholder: '{{__("equicare.select_option")}}',
				allowClear: true,
				tags: true,
				ajax: {
					url: "{{url('department_equipment')}}/" + hospital_id,
					dataType: 'json'
				}
			});
		});
	});
</script>
@endsection
@section('styles')
<style type="text/css">
	.select2-container {
		display: block;
	}
</style>
@endsection