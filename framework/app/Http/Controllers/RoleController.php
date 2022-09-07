<?php

namespace App\Http\Controllers;
use App\Http\Requests\RoleCreate;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$index['page'] = 'roles';
		$index['roles'] = Role::all();
		$this->availibility('View Roles');
		return view('roles.index', $index);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$index['page'] = 'roles';
		$this->availibility('Create Roles');
		$index['permissions'] = Permission::all();
		return view('roles.create', $index);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(RoleCreate $request) {
		$role = new Role;

		$role->name = $request->name;
		$role->save();
		$permissions = $request->permissions;
		$name = $request->name;
		foreach ($permissions as $permission) {
			$p = Permission::where('id', '=', $permission)->firstOrFail();
			$role = Role::where('name', '=', $name)->first();
			$role->givePermissionTo($p);
		}

		app()['cache']->forget('spatie.permission.cache');

		return redirect()->route('roles.index')
			->with('flash_message',
				'Role "' . $role->name . '" added!');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$index['page'] = 'roles';

		$this->availibility('Edit Roles');

		$index['role'] = Role::findOrFail($id);
		$index['permissions'] = Permission::all();

		return view('roles.edit', $index);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$role = Role::findOrFail($id);
		$role->name = $request->name;
		$role->save();
		$permissions = $request->permissions;

		foreach ($role->permissions as $rp) {

			$p = Permission::where('id', '=', $rp->id)->get();

			$role->revokePermissionTo($p);
		}

		if (isset($permissions)) {

			foreach ($permissions as $permission) {
				$p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form permission in db

				$role->givePermissionTo($p);

			}
		}

		app()['cache']->forget('spatie.permission.cache');

		return redirect()->route('roles.index')
			->with('flash_message',
				'Role "' . $role->name . '" Updated!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$role = Role::findOrFail($id);
		$this->availibility('Delete Roles');
		$role->delete();

		return redirect()->route('roles.index')
			->with('flash_message',
				'Role ' . $role->name . ' Deleted!');
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
