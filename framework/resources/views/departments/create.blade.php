@extends('layouts.admin')
@section('body-title')
@lang('equicare.departments')
@endsection
@section('title')
| @lang('equicare.departments')
@endsection
@section('breadcrumb')
<li><a href="{{ route('departments.index') }}">@lang('equicare.departments')</a></li>
<li class="active">@lang('equicare.create_department')</li>
@endsection
@section('styles')
<style type="text/css">
	.mt-2 {
		margin-top: 10px;
	}
</style>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title">
					@lang('equicare.create_department')
				</h4>
			</div>
			<div class="box-body">
				@include ('errors.list')
				{!! Form::open(['url'=>'admin/departments','method'=>'POST']) !!}
				<div class="row">
					<div class="form-group col-md-6">
						{!! Form::label('name',__('equicare.name')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::text('name',null,['class' => 'form-control']) !!}
					</div>
					<div class="form-group col-md-6">
						{!! Form::label('short_name',__('equicare.short_name_e')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::text('short_name',null,['class' => 'form-control']) !!}
					</div>
					<div class="form-group col-md-6">
						{!! Form::label('hospital_id',__('equicare.hospital')) !!}
						<span class="text-red">&nbsp;*</span>
						{!! Form::select('hospital_id',$hospitals??[],null,['placeholder'=>__('equicare.select_option'),'class' => 'form-control select2']) !!}
					</div>

					<div class="form-group col-md-12">
						{!! Form::submit(__('equicare.submit'),['class' => 'btn btn-primary btn-flat']) !!}
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('.select2').select2({
			placeholder: '{{__("equicare.select_option")}}',
			allowClear: true,
			tags: true,
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