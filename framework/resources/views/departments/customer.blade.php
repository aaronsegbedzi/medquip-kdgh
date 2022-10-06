@extends('layouts.admin')
@section('body-title')
@lang('equicare.departments') - {{ $departments[0]->hospital->name }}
@endsection
@section('title')
	| @lang('equicare.departments')
@endsection
@section('breadcrumb')
	<li class=" active">@lang('equicare.departments')</li>
@endsection
@section('content')
		<div class="row">
			<div class="col-md-12">
				<div class="box box-primary">
					<div class="box-body table-responsive">
						<table class="table table-striped table-bordered table-condensed table-hover dataTable bottom-padding" id="data_table">
							<thead class="thead-inverse">
								<tr>
									<th class="text-center"> # </th>
									<th> @lang('equicare.name') </th>
									<th> @lang('equicare.short_name') </th>
									<th> @lang('equicare.hospital') </th>
									<th> No. @lang('equicare.equipment') </th>
									<th> @lang('equicare.action')</th>
								</tr>
							</thead>
							<tbody>
								@if (isset($departments))
								@php
									$count = 0;
								@endphp
								@foreach ($departments as $department)
								@if ($department->equipments->count() > 0)
								@php
									$count++;
								@endphp
								<tr>
								<td class="text-center"> {{ $count }}</td>
								<td>{{ ucfirst($department->name) }}</td>
								<td>{{ $department->short_name ?? "-" }}</td>
								<td>{{ $department->hospital->name ?? "-" }}</td>
								<td class="text-center">{{ $department->equipments->count() ?? "-" }}</td>
								<td class="text-center">
									<a href="{{ url('/customer/department/'.$department->id) }}" class="btn btn-sm btn-primary btn-flat">
										<i class="fa fa-eye"></i>
									</a>
								</td>
								</tr>
								@endif
								@endforeach
								@endif
							</tbody>
							<tfoot>
								<tr>
									<th class="text-center"> # </th>
									<th> @lang('equicare.name') </th>
									<th> @lang('equicare.short_name') </th>
									<th> @lang('equicare.hospital') </th>
									<th> @lang('equicare.action')</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
@endsection