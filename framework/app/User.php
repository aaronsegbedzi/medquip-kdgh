<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
	use Notifiable;
	use HasRoles;
	use SoftDeletes;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $table = 'users';
	protected $fillable = [
		'name', 'email', 'password','phone',
	];
	protected $metaTable = 'users_meta';
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	protected function getMetaKeyName() {
		return 'user_id'; // The parent foreign key
	}
	public function role() {
		return $this->belongsTo('App\Role', 'role_id');
	}
}
