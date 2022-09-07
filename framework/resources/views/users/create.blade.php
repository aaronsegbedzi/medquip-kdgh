@extends('layouts.admin')
@section('body-title')
@lang('equicare.users')
@endsection
@section('title')
	| @lang('equicare.users')
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('admin/users') }}">@lang('equicare.users') </a></li>
<li class="breadcrumb-item active">@lang('equicare.create')</li>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">@lang('equicare.create_user')</h4>
				</div>

				<div class="box-body ">
					@include ('errors.list')
					<form class="form" method="post" action="{{ route('users.store') }}">
						{{ csrf_field() }}
						<input type="hidden" name="_method" value="POST"/>
						<div class="row">
						<div class="form-group col-md-6">
							<label for="name"> @lang('equicare.name') </label>
							<input type="text" name="name" class="form-control"
							value="{{ old('name') }}" />
						</div>
						<div class="form-group col-md-6">
							<label for="email"> @lang('equicare.email') </label>
							<input type="email" name="email" class="form-control" value="{{ old('email') }}"/>
						</div>
						<div class="form-group col-md-6">
							<label for="role"> @lang('equicare.role') </label>
							<select name="role" class="form-control">
								<option value=""> </option>
								@foreach ($roles as $role)
									<option value="{{ $role->name }}">{{ $role->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="password"> @lang('equicare.password') </label>
							<input type="password" name="password" class="form-control"/>
						</div>
						<div class="form-group col-md-6">
							<label for="password_confirmation"> @lang('equicare.confirm_password') </label>
							<input type="password" name="password_confirmation" class="form-control"/>
						</div>
						<div class="form-group col-md-12">
							<input type="submit" value="@lang('equicare.submit')" class="btn btn-primary btn-flat"/>
						</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
@endsection