<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model {
	use SoftDeletes;

	protected $table = 'hospitals';
	protected $fillable = ['name', 'slug', 'address', 'contact_person', 'phone_no', 'mobile_no', 'email', 'user_id', 'logo'];

	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}
	public function setSlugAttribute($value) {
		$this->attributes['slug'] = strtoupper($value);
	}
}
