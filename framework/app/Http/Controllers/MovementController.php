<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;

class MovementController extends Controller
{
    /**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function moveEquipment($equip_id, $hospital_id, $user_id, $from, $to) {
		$movement = new Movement;
		$movement->equip_id = $equip_id;
		$movement->hospital_id = $hospital_id;
		$movement->user_id = $user_id;
		$movement->from_department = $from;
		$movement->to_department = $to;
		$movement->date = date('Y-m-d H:i:s');
		$movement->save();
	}

}
