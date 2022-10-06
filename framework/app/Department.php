<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model {
	use SoftDeletes;
	protected $table = 'departments';

	protected $fillable = ['name', 'short_name', 'hospital_id'];

	public function equipments() {
		return $this->hasMany('App\Equipment', 'department');
	}

	public function hospital() {
		return $this->belongsTo('App\Hospital', 'hospital_id');
	}

}
