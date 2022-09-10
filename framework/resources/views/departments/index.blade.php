@extends('layouts.admin')
@section('body-title')
@lang('equicare.departments')
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
				<div class="box-header with-border">
					<h4 class="box-title">@lang('equicare.manage_departments')
							@can('Create Departments')
								<a href="{{ route('departments.create') }}" class="btn btn-primary btn-flat">@lang('equicare.add_new')</a>
							@endcan
						</h4>
					</div>
					<div class="box-body table-responsive">
						<table class="table table-striped table-bordered table-hover dataTable bottom-padding" id="data_table">
							<thead class="thead-inverse">
								<tr>
									<th class="text-center"> # </th>
									<th> @lang('equicare.name') </th>
									<th> @lang('equicare.short_name') </th>
									<th> @lang('equicare.created_on') </th>
									@if (\Auth::user()->can('Edit Departments') || \Auth::user()->can('Delete Departments'))
									<th> @lang('equicare.action')</th>
									@endif
								</tr>
							</thead>
							<tbody>
								@if (isset($departments))
								@php
									$count = 0;
								@endphp
								@foreach ($departments as $department)
								@php
									$count++;
								@endphp
								<tr>
								<td class="text-center"> {{ $count }} </td>
								<td> {{ ucfirst($department->name) }} </td>
								<td>{{ $department->short_name ?? "-" }}</td>
								<td> {{ $department->created_at->diffForHumans() }}</td>
								@if (\Auth::user()->can('Edit Departments') || \Auth::user()->can('Delete Departments'))
								<td class="todo-list">
									<div class="tools">
										{!! Form::open(['url' => 'admin/departments/'.$department->id,'method'=>'DELETE','class'=>'form-inline']) !!}
										@can('Edit Departments')
											<a href="{{ route('departments.edit',$department->id) }}" class="btn btn-warning btn-flat btn-sm" title="@lang('equicare.edit')"><i class="fa fa-edit"></i>  </a>
										@endcan &nbsp;
										@can('Delete Departments')
				                            <input type="hidden" name="id" value="{{ $department->id }}">
				                            <button class="btn btn-danger btn-flat btn-sm" type="submit" onclick="return confirm('@lang('equicare.are_you_sure')')" title="@lang('equicare.delete')"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
				                        @endcan
				                        {!! Form::close() !!}
									</div>
								</td>
								@endif
								</tr>
								@endforeach
								@endif
							</tbody>
							<tfoot>
								<tr>
									<th class="text-center"> # </th>
									<th> @lang('equicare.name') </th>
									<th> @lang('equicare.short_name') </th>
									<th> @lang('equicare.created_on') </th>
									@if (\Auth::user()->can('Edit Departments') || \Auth::user()->can('Delete Departments'))
									<th> @lang('equicare.action')</th>
									@endif
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
@endsection