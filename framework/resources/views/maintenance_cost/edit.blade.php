@extends('layouts.admin')
@section('body-title')
@lang('equicare.maintenance_cost')
@endsection
@section('title')
| @lang('equicare.maintenance_cost_edit')
@endsection
@section('breadcrumb')
<li>
	<a href="{{ url('admin/maintenance_cost') }}">
		@lang('equicare.maintenance_cost')
	</a>
</li>
<li class="active">@lang('equicare.edit')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title">@lang('equicare.maintenance_cost_edit')</h4>
			</div>
			<div class="box-body ">
				<form class="form" method="post" action="{{ route('maintenance_cost.update',$maintenance_cost->id) }}">
					{{ csrf_field() }}
					{{ method_field('PATCH') }}
					<div class="row">
						<div class="form-group col-md-4">
							{!! Form::label('hospital_id',__('equicare.hospital')) !!}
							<span class="text-red">&nbsp;*</span>
							{!! Form::select('hospital_id',$hospitals??[],$maintenance_cost->hospital_id,['class' => $errors->has('hospital_id')?'is-invalid form-control select2_hospital':'form-control select2_hospital','placeholder'=>'Select Hospital']) !!}
							@if ($errors->has('hospital_id'))
							<strong class="invalid-feedback">
								<span>{{ $errors->first('hospital_id') }}
								</span>
							</strong>
							@endif
						</div>
						<div class="form-group col-md-6">
							<label>@lang('equicare.type')<span class="text-red">&nbsp;*</span>:</label>
							<div class="radio iradio">
								<label class="login-padding">
									{!! Form::radio('type', 'amc',$maintenance_cost->type=='amc'?true:false,['class'=>$errors->has('type')?'is-invalid':''])!!} @lang('equicare.annual_cost')
								</label>
								<label>
									{!! Form::radio('type', 'cmc',$maintenance_cost->type=='cmc'?true:false,['class'=>$errors->has('type')?'is-invalid':''])!!} @lang('equicare.comprehensive_cost')
								</label>
								<br/>
								@if ($errors->has('type'))
								<strong class="invalid-feedback">
									<span>{{ $errors->first('type') }}
									</span>
								</strong>
								@endif
							</div>
						</div>
						<div class="form-group col-md-3">
							<label class="margintop">@lang('equicare.cost_by')<span class="text-red">&nbsp;*</span>:</label>
							<div class="radio iradio zmargin">
								<label class="login-padding">
									{!! Form::radio('cost_by', 'us',$maintenance_cost->cost_by=='us'?true:false)!!} @lang('equicare.own_company')
								</label>
								<label>
									{!! Form::radio('cost_by', 'tp',$maintenance_cost->cost_by=='tp'?true:false,['id'=>'tp'])!!} @lang('equicare.third_party')
								</label>
								@if ($errors->has('cost_by'))
								<strong class="invalid-feedback">
									<span>{{ $errors->first('cost_by') }}
									</span>
								</strong>
								@endif
							</div>
						</div>
						<div class="form-group col-md-9 tp_details" style="display: {{ $maintenance_cost->cost_by=='tp'?'block':'none' }}">
							<div class="row no-gutters">
								<div class="form-group col-md-4">
									<label for="tp_name"> @lang('equicare.name') </label>
									<input type="text" id="tp_name" name="tp_name" class="{{ $errors->has('tp_name')?'is-invalid ':'' }}form-control" value="{{ $maintenance_cost->tp_name??old('tp_name') }}" />
									@if ($errors->has('tp_name'))
									<strong class="invalid-feedback">
										<span>{{ $errors->first('tp_name') }}
										</span>
									</strong>
									@endif
								</div>
								<div class="form-group col-md-4">
									<label for="tp_mobile"> @lang('equicare.mobile') </label>
									<input type="text" id="tp_mobile" name="tp_mobile" class="{{ $errors->has('tp_mobile')?'is-invalid ':'' }}form-control" value="{{ $maintenance_cost->tp_mobile??old('tp_mobile') }}" />
									@if ($errors->has('tp_mobile'))
									<strong class="invalid-feedback">
										<span>{{ $errors->first('tp_mobile') }}
										</span>
									</strong>
									@endif
								</div>
								<div class="form-group col-md-4">
									<label for="tp_email"> @lang('equicare.email') </label>
									<input type="text" id="tp_email" name="tp_email" class="{{ $errors->has('tp_email')?'is-invalid ':'' }}form-control" value="{{ $maintenance_cost->tp_email??old('tp_email') }}" />
									@if ($errors->has('tp_email'))
									<strong class="invalid-feedback">
										<span>{{ $errors->first('tp_email') }}
										</span>
									</strong>
									@endif
								</div>
							</div>
						</div>
					</div>
					{!! Form::label('equipments','Select Equipments') !!}
					<div class="add_row_equipments">
						@php($i = 0)
						@if((old('cost')))
						@foreach(old('cost') as $input)
						<div class="row no-gutters">
							<div class="form-group col-md-3">
								{!! Form::select('equipments[]',[],old('equipments.'.$i),['class'=>$errors->has('equipments.'.$i)?'is-invalid form-control select2_equipments':'form-control select2_equipments','id'=>'equipments'.($i+1)]) !!}
								@if ($errors->has('equipments.'.$i))
								<strong class="invalid-feedback">
									<span>{{ $errors->first('equipments.'.$i) }}
									</span>
								</strong>
								@endif
							</div>
							<div class="form-group col-md-3">
								{!! Form::text('start_dates[]',old('start_dates.'.$i),['class'=>$errors->has('start_dates.'.$i)?'is-invalid start_dates form-control':'form-control start_dates','placeholder'=>__('equicare.enter_start_date'),'autocomplete'=>'off']) !!}
								@if ($errors->has('start_dates.'.$i))
								<strong class="invalid-feedback">
									<span>{{ $errors->first('start_dates.'.$i) }}
									</span>
								</strong>
								@endif
							</div>
							<div class="form-group col-md-3">
								{!! Form::text('end_dates[]',old('end_dates.'.$i),['class'=>$errors->has('end_dates.'.$i)?'is-invalid end_dates form-control':'form-control end_dates','placeholder'=>__('equicare.enter_end_date'),'autocomplete'=>'off']) !!}
								@if ($errors->has('end_dates.'.$i))
								<strong class="invalid-feedback">
									<span>{{ $errors->first('end_dates.'.$i) }}
									</span>
								</strong>
								@endif
							</div>
							<div class="form-group col-md-3">
								{!! Form::text('cost[]',old('cost.'.$i),['class'=>$errors->has('cost.'.$i)?'is-invalid cost form-control':'form-control cost','placeholder'=>__('equicare.enter_cost'),'autocomplete'=>'off']) !!}
								@if ($errors->has('cost.'.$i))
								<strong class="invalid-feedback">
									<span>{{ $errors->first('cost.'.$i) }}
									</span>
								</strong>
								@endif
							</div>
							@php($i++)
						</div>
						@endforeach
						@else
						@foreach(json_decode($maintenance_cost->costs, TRUE) as $key => $cost)
						<div class="row no-gutters">
							<div class="form-group col-md-3">
								{!! Form::select('equipments[]',$equipments??[],json_decode($maintenance_cost->equipment_ids,TRUE)[$key],['class'=>'form-control select2_equipments','id'=>'equipments1']) !!}
							</div>
							<div class="form-group col-md-3">
								{!! Form::text('start_dates[]',date('Y-m-d',strtotime(json_decode($maintenance_cost->start_dates,TRUE)[$key])),['class'=>'form-control start_dates','placeholder'=>__('equicare.enter_start_date'),'id'=>'start_dates1','autocomplete'=>'off']) !!}
							</div>
							<div class="form-group col-md-3">
								{!! Form::text('end_dates[]',date('Y-m-d',strtotime(json_decode($maintenance_cost->end_dates,TRUE)[$key])),['class'=>'form-control end_dates','placeholder'=>__('equicare.enter_end_date'),'id'=>'end_dates1','autocomplete'=>'off']) !!}
							</div>
							<div class="form-group col-md-3">
								{!! Form::text('cost[]',$cost,['class'=>'form-control','placeholder'=>__('equicare.enter_cost')]) !!}
							</div>
						</div>
						@endforeach
						@endif
					</div>
					<div class="form-group col-md-12 login-padding">
						{!! Form::submit(__('equicare.submit'),['class' => 'btn btn-primary btn-flat']) !!}
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/datetimepicker.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function() {
		@if($errors->has('tp_name') || $errors->has('tp_email') || $errors->has('tp_mobile'))
		$('div.tp_details').show();
		@endif
		if($('#tp').attr('checked') =='checked'){
			$('.tp_details').css('display','block');
		}
		$('#tp').on('ifChecked ifUnchecked',function(e){
			if(e.type == 'ifChecked'){
				$('.tp_details').show();
			}else{
				$('.tp_details').hide();
			}
		})
		$('.start_dates').datepicker({
			todayHighlight: true,
			format: 'yyyy-mm-dd'
		});
		$('.end_dates').datepicker({
			todayHighlight: true,
			format: 'yyyy-mm-dd'
		});
		$('.select2_equipments').select2({
			placeholder: '{{__("equicare.select_option")}}',
			allowClear: true
		});
		$('.select2_hospital').select2({
			placeholder:'{{__("equicare.select_option")}}',
			allowClear:true
		});
		var $i = 1;
		$('.add_btn').on('click',function(e){
			$i++;
			if($('.add_row_equipments').children('.row').length >= 1){
				$('.delete_row_btn').show();
			}else{
				$('.delete_row_btn').hide();
			}
			$(this).parent().siblings('.add_row_equipments').append(
				'<div class="row no-gutters">'+
				'<div class="form-group col-md-3">  '  +
				'	<select name="equipments[]" class="form-control select2_equipments" id="equipments'+$i+'">'  +
				'		<option></option>'+
				'	</select>'+
				'</div>  '  +
				'<div class="form-group col-md-3">  '  +
				' <input type="text" name="start_dates[]" id="start_dates'+$i+'" class="form-control start_dates" placeholder="{{__("equicare.enter_start_date")}}">	'+
				'</div>  '  +
				'<div class="form-group col-md-3">  '  +
				' <input type="text" name="end_dates[]" id="end_dates'+$i+'" class="form-control end_dates" placeholder="{{__("equicare.enter_end_date")}}">	'+
				' </div>  '  +
				' <div class="form-group col-md-3">  '  +
				' 	{!! Form::text('cost[]',null,['class'=>'form-control','placeholder'=>'{{__("equicare.enter_cost")}}']) !!}  '  +
				' </div>  ' +
				' </div> ');
			$('#equipments'+$i).select2({
				placeholder: '{{__("equicare.select_option")}}',
				allowClear: true
			});
			$('#start_dates'+$i).datepicker({
				todayHighlight: true,
				format: 'yyyy-mm-dd'
			});
			$('#end_dates'+$i).datepicker({
				todayHighlight: true,
				format: 'yyyy-mm-dd'
			});
		});

		if($('.add_row_equipments').children('.row').length > 1){
			$('.delete_row_btn').show();
		}
		$('.delete_row_btn').on('click',function(e){

			if($('.add_row_equipments').children('.row').length == 2){
				$('.delete_row_btn').hide();
			}else{
				$('.delete_row_btn').show();
			}
			e.preventDefault();
			$(this).parent().siblings('.add_row_equipments').children('.row :last').remove();
		});
		setTimeout(loadEquipAjax,500);
		$('select[name=hospital_id]').on('change',function(){
			var hospital_id = $(this).val();
			$.ajax({
				url:"{{ url('get_equipment') }}",
				type:'get',
				data:{
					'hospital_id':hospital_id,
				},
				success:function(data){
					if(data.equipments.length == 0){
						alert('{{__("equicare.select_other_hospital")}}');
					}else{
						$('.select2_equipments').empty();
						$('.select2_equipments').append(
							'<option value=""></option>');
							<?php $key = 0?>
						for(n in data.equipments){
							console.log(n);
							// $('.select2_equipments').select2('destroy');
							if(n == {{ json_decode($maintenance_cost->equipment_ids,TRUE)[$key] }}){
							$('.select2_equipments').append(
								'<option value='+n+' selected>'+data.equipments[n]+'</option>'
								);
							}else{
								$('.select2_equipments').append(
								'<option value='+n+'>'+data.equipments[n]+'</option>'
								);
							}
							<?php $key++;?>
						}
							$('.select2_equipments').select2({
								placeholder:'{{__("equicare.select_option")}}',
								allowClear:true
							});
					}
				},
				error:function(data){

				}
			});
		});
	});
	function loadEquipAjax(){
		if($('select[name=hospital_id]').val()){
			$('select[name=hospital_id]').trigger('change');
		}
	}
</script>
<script type="text/javascript">
	$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>
@endsection
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}">
<style type="text/css">
.no-gutters {
	margin-right: 0;
	margin-left: 0;
}
.no-gutters > .col-md-3,.no-gutters > .col-md-4 {
	padding-right: 10;
	padding-left: 0;
}

.is-invalid + span.select2-container{
	border:1px solid red !important;
}

.is-invalid{
	border:1px solid red !important;
}
.invalid-feedback{
	color:red;
}
.is-invalid < .iradio_minimal-blue{
	background: url(red.png) no-repeat;
}
.form-group{
	max-height: 62px;
}
.tp_details .row{
	display: block;
}
</style>
@endsection