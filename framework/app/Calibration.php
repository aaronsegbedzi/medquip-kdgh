<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calibration extends Model {
	use SoftDeletes;
	protected $dates = ['deleted_at'];
	protected $table = 'calibrations';

	public function equipment() {
		return $this->belongsTo('App\Equipment', 'equip_id')->withTrashed();
	}
	public function user() {
		return $this->belongsTo('App\User', 'user_id');
	}
}
