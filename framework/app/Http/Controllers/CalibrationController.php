<?php

namespace App\Http\Controllers;

use App\Calibration;
use App\Department;
use App\Equipment;
use App\Hospital;
use App\Http\Requests\CalibrationRequest;
use App\User;
use Auth;

class CalibrationController extends Controller {
	public function index() {
		$this->availibility('View Calibrations');

		$index['page'] = 'calibrations';
		$index['calibrations'] = Calibration::all();
		$index['users'] = User::pluck('name', 'id');
		return view('calibrations.index', $index);
	}

	public function create() {
		$this->availibility('Create Calibrations');
		$index['page'] = 'calibrations';
		$index['unique_ids'] = Equipment::pluck('unique_id', 'id')->toArray();
		$index['departments'] = Department::select('id', \DB::raw('CONCAT(short_name,"(",name,")") as department'))->pluck('department', 'id')->toArray();
		$index['hospitals'] = Hospital::pluck('name', 'id')->toArray();
		return view('calibrations.create', $index);
	}

	public function store(CalibrationRequest $request) {
		$calibration = new Calibration;
		$calibration->date_of_calibration = $request->date_of_calibration;
		$calibration->due_date = $request->due_date;
		$calibration->equip_id = $request->equip_id;
		$calibration->user_id = Auth::id();
		$calibration->certificate_no = $request->certificate_no;
		$calibration->company = $request->company_this;
		$calibration->contact_person = $request->contact_person;
		$calibration->contact_person_no = $request->contact_person_no;
		$calibration->engineer_no = $request->engineer_no;
		$calibration->traceability_certificate_no = $request->traceability_certificate_no;
		$calibration->save();

		return redirect('admin/calibration')->with('flash_message', 'Calibration created');
	}

	public function edit($id) {
		$this->availibility('Edit Calibrations');
		$index['page'] = 'calibrations';
		$index['calibration'] = Calibration::findOrFail($id);
		$index['hospitals'] = Hospital::pluck('name', 'id')->toArray();

		$index['unique_ids'] = Equipment::where('hospital_id', $index['calibration']->equipment->hospital_id)
			->pluck('unique_id', 'id')
			->toArray();

		$index['departments'] = Department::select('id', \DB::raw('CONCAT(short_name,"(",name,")") as department'))->pluck('department', 'id')->toArray();
		return view('calibrations.edit', $index);
	}

	public function update(CalibrationRequest $request, $id) {
		$calibration = Calibration::findOrFail($id);
		$calibration->date_of_calibration = $request->date_of_calibration;
		$calibration->due_date = $request->due_date;
		$calibration->equip_id = $request->unique_id;
		$calibration->certificate_no = $request->certificate_no;
		$calibration->company = $request->company;
		$calibration->contact_person_no = $request->contact_person_no;
		$calibration->engineer_no = $request->engineer_no;
		$calibration->traceability_certificate_no = $request->traceability_certificate_no;
		$calibration->save();

		return redirect('admin/calibration')->with('flash_message', 'Calibration updated	');
	}

	public function destroy($id) {
		$this->availibility('Delete Calibrations');
		$calibration = Calibration::findOrFail($id);
		$calibration->delete();
		return redirect('admin/calibration')->with('flash_message', 'Calibration deleted	');
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
