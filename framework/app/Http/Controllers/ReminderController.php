<?php

namespace App\Http\Controllers;

use App\Calibration;
use App\CallEntry;

class ReminderController extends Controller {

	public function preventive_reminder() {
		$date = [
			date('Y-m-d', strtotime('+6 days')),
			date('Y-m-d', strtotime('+1 days')),
		];
		$index['page'] = 'preventive_maintenance_reminder';
		$index['preventive_reminder'] = CallEntry::where('call_type', 'preventive')
			->orderBy('next_due_date', 'asc')
			->paginate(10);

		return view('reminder.preventive_maintenance_reminder', $index);
	}
	public function calibrations_reminder() {
		$index['page'] = 'calibrations_reminder';
		$index['calibrations'] = Calibration::orderBy('due_date', 'asc')
			->paginate(10);
		return view('reminder.calibrations_reminder', $index);
	}
}
