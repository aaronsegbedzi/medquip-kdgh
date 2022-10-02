<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index() {
		$this->availibility('View Users');
		$index['page'] = 'users';
		$index['users'] = User::all();

		return view('users.index', $index);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$index['page'] = 'users';
		$index['roles'] = Role::all();
		$index['hospitals'] = Hospital::pluck('name', 'id')->toArray();

		$this->availibility('Create Users');
		return view('users.create', $index);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(UserCreateRequest $request) {
		$user = User::create($request->only('name', 'email', 'phone', 'hospital_id'));
		$user->password = bcrypt($request->password);
		$user->assignRole($request->role);
		$user->save();

		return redirect()->route('users.index')
			->with('flash_message',
				'User "' . $user->name . '" added.');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$index['page'] = 'users';
		$index['user'] = User::findOrFail($id);
		$index['roles'] = Role::all();
		$index['hospitals'] = Hospital::pluck('name', 'id')->toArray();
		$this->availibility('Edit Users');
		$permissions = Permission::all();
		$role_p = $index['user']->getPermissionsViaRoles()->pluck('id')->toArray();

		$index['permissions'] = Permission::whereNotIn('id', $role_p)
			->get();

		return view('users.edit', $index);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UserUpdateRequest $request, $id) {
		$user = User::findOrFail($id);
		$user->update($request->only('name', 'email', 'phone', 'hospital_id'));
		$user->password = bcrypt($request->password);
		if ($request->role) {
			$user->roles()->sync($request->role);
		} else {
			$user->roles()->detach();
		}
		$user->role_id = $request->role;
		if (isset($request->permissions)) {
			$perm = Permission::whereIn('id', $request->permissions)->get();
			$user->syncPermissions($perm->pluck('name')->toArray());
		} else {
			$user->revokePermissionTo(Permission::pluck('name')->toArray());
		}

		$user->save();

		app()['cache']->forget('spatie.permission.cache');

		return redirect()->route('users.index')
			->with('flash_message',
				'User "' . $user->name . '" updated.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$user = User::findOrFail($id);
		$this->availibility('Delete Users');

		if ($user->id == \Auth::user()->id) {
			return redirect('admin/users')->with('flash_message_error',
				' Logged In User  can not Delete.');
		}
		$user->delete();
		return redirect('admin/users')->with('flash_message',
			'User "' . $user->name . '" deleted.');
	}
	public static function availibility($method) {
		$r_p = \Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray();
		if (\Auth::user()->hasPermissionTo($method)) {
			return true;
		} elseif (!in_array($method, $r_p)) {
			abort('401');
		} else {
			return true;
		}
	}
}
