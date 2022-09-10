@extends('layouts.admin')
@section('body-title')
@lang('equicare.calibrations')
@endsection
@section('title')
| @lang('equicare.calibrations')
@endsection
@section('breadcrumb')
<li class="active">@lang('equicare.calibrations')</li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">@lang('equicare.calibrations')
					@can('Create Calibrations')
					<a href="{{ route('calibration.create') }}" class="btn btn-primary btn-flat">@lang('equicare.add_new')</a>
					@endcan
				</h4>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table id="data_table" class="table table-condensed table-bordered table-striped table-hover bottom-padding">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th> @lang('equicare.calibrations') </th>
								<th> @lang('equicare.user') </th>
								<th> @lang('equicare.calibration_date') </th>
								<th> @lang('equicare.due_date') </th>
								<th> @lang('equicare.certificate-no') </th>
								<th> @lang('equicare.company') </th>
								<th> @lang('equicare.contact_person') </th>
								@if(Auth::user()->can('Edit Calibrations') || Auth::user()->can('Delete Calibrations'))
									<th> @lang('equicare.action') </th>
								@endif
							</tr>
						</thead>
						<tbody>
							@php $count=0; @endphp
							@if (isset($calibrations))
							@foreach ($calibrations as $calibration)
							@php $count++; @endphp
							<tr>
								<td class="text-center">{{ $count }} </td>
								<td>{{ $calibration->equipment->name?? '' }} </td>
								<td>{{ucwords($calibration->user->name)?? '' }} </td>
								<td>{{ $calibration->date_of_calibration }} </td>
								<td>{{ $calibration->due_date }} </td>
								<td>{{ $calibration->certificate_no }} </td>
								<td>{{ $calibration->company }} </td>
								<td>{{ $calibration->contact_person }} </td>
								@if(Auth::user()->can('Edit Calibrations') || Auth::user()->can('Delete Calibrations'))
			                        <td >
										{!! Form::open(['url' => 'admin/calibration/'.$calibration->id,'method'=>'DELETE','class'=>'form-inline']) !!}
											@can('Edit Calibrations')
											<a href="{{ route('calibration.edit',$calibration->id) }}" class="btn btn-warning btn-sm btn-flat" title="@lang('equicare.edit')"><i class="fa fa-edit"></i>  </a>
											@endcan &nbsp;
				                            <input type="hidden" name="id" value="{{ $calibration->id }}">
				                            @can('Delete Calibrations')
				                            <button class="btn btn-danger btn-sm btn-flat" type="submit" onclick="return confirm('@lang('equicare.are_you_sure')')" title="@lang('equicare.delete')"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
				                            @endcan
				                        {!! Form::close() !!}

									</td>
								@endif
							</tr>
							@endforeach
							@endif
						</tbody>
						<tfoot>
							<tr>
								<th class="text-center">#</th>
								<th> @lang('equicare.calibrations') </th>
								<th> @lang('equicare.user') </th>
								<th> @lang('equicare.calibration_date') </th>
								<th> @lang('equicare.due_date') </th>
								<th> @lang('equicare.certificate-no') </th>
								<th> @lang('equicare.company') </th>
								<th> @lang('equicare.contact_person') </th>
								@if(Auth::user()->can('Edit Calibrations') || Auth::user()->can('Delete Calibrations'))
									<th> @lang('equicare.action') </th>
								@endif	
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection