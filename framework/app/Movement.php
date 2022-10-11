<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{

	protected $table = 'movements';

	protected $fillable = ['equip_id', 'hospital_id', 'user_id', 'from_department', 'to_department'];

	public function equipment() {
		return $this->belongsTo('App\Equipment', 'equip_id');
	}

    public function hospital() {
		return $this->belongsTo('App\Hospital', 'hospital_id');
	}

	public function fromDepartment() {
		return $this->belongsTo('App\Department', 'from_department');
	}

	public function toDepartment() {
		return $this->belongsTo('App\Department', 'to_department');
	}

    public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}

}
