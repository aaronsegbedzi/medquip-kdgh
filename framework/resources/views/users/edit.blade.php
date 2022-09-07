@extends('layouts.admin')
@section('body-title')
@lang('equicare.users')
@endsection
@section('title')
	| @lang('equicare.users')
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('admin/users') }}">@lang('equicare.users')</a></li>
<li class="breadcrumb-item active">@lang('equicare.edit')</li>
@endsection
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">@lang('equicare.edit_user')</h4>
				</div>
				<div class="box-body ">
					@include ('errors.list')
					<form class="form" method="post" action="{{ route('users.update',$user->id) }}">
						{{ csrf_field() }}
						<input type="hidden" name="_method" value="PATCH"/>
						<div class="row">
						<div class="form-group col-md-6">
							<label for="name"> @lang('equicare.name') </label>
							<input type="text" name="name" value="{{ $user->name }}" class="form-control"/>
							<input type="hidden" name="id" value="{{ $user->id }}">
						</div>
						<div class="form-group col-md-6">
							<label for="email"> @lang('equicare.email') </label>
							<input type="email" name="email" value="{{ $user->email }}" class="form-control"/>
						</div>


						<div class="form-group col-md-6">
							<label for="role"> @lang('equicare.role') </label>
							<select name="role" class="form-control ">
								<option value=""> </option>
								@foreach ($roles as $role)
									<option value="{{ $role->id}}"
										{{ in_array($role->id, $user->roles->pluck('id')->toArray())? 'selected':'' }}
										> {{ ucfirst($role->name) }}</option>
										}
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6">
							<label for="password"> @lang('equicare.password') </label>
							<input type="password" value="" name="password" class="form-control col-md-6"/>
						</div>
						@if (isset($permissions) && $permissions->count() > 0)
						<div class="form-group col-md-12">
							<label for="permissions[]" > @lang('equicare.permissions') </label>
							<div class="form-check">
								<input type="checkbox" name="check_all" id="check_all"/>
								<label for="check_all"> @lang('equicare.check_all')</label>
								<br/>

							<div class="row">
							@foreach ($permissions as $permission)

							<div class="col-md-4">
								<input type="checkbox" name="permissions[]" class="" @if(in_array($permission->id, $user->permissions->pluck('id')->toArray()))
										  {{ "checked" }}
								  @endif  value="{{ $permission->id }}" />
								<label for="permissions[]" class="form-check-label">{{ $permission->name }}  </label><br/>
								</div>
								@endforeach
							</div>
						</div>
					</div>
					@endif
						<br/>
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