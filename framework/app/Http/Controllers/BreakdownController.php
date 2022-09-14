<?php

namespace App\Http\Controllers;
use App\CallEntry;
use App\Department;
use App\Equipment;
use App\Hospital;
use App\ServiceRenderedItem;
use App\Http\Requests\BreakdownCreateRequest;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class BreakdownController extends Controller {

	public function index() {
		$this->availibility('View Breakdown Maintenance');
		$index['page'] = 'breakdown_maintenance';
		$index['b_maintenance'] = CallEntry::where('call_type', 'breakdown')->latest()->get();
		$index['services'] = ServiceRenderedItem::pluck('new_item', 'new_item')->toArray();
		$index['users'] = User::pluck('name', 'id');
		return view('call_breakdowns.index', $index);
	}

	public function create() {
		$this->availibility('Create Breakdown Maintenance');
		$index['page'] = 'breakdown_maintenance';
		$index['serial_no'] = Equipment::pluck('sr_no', 'id')->toArray();
		$index['departments'] = Department::select('id', \DB::raw('CONCAT(short_name,"(",name,")") as department'))->pluck('department', 'id')->toArray();
		$index['hospitals'] = Hospital::pluck('name', 'id')->toArray();
		return view('call_breakdowns.create', $index);
	}

	public function store(BreakdownCreateRequest $request) {
		$breakdown = new CallEntry;
		$breakdown->call_handle = $request->call_handle;
		$breakdown->call_type = 'breakdown';
		$breakdown->equip_id = $request->equip_id;
		$breakdown->user_id = Auth::id();
		$report_no = CallEntry::where('call_handle', 'internal')->count();
		if ($breakdown->call_handle == 'external') {
			$breakdown->report_no = $request->report_no;
		} elseif ($breakdown->call_handle == 'internal') {
			$breakdown->report_no = $report_no + 1;
		}
		if (isset($request->call_register_date_time)) {
			$call_register_date_time = \Carbon\Carbon::parse($request->call_register_date_time);

			$breakdown->call_register_date_time = $call_register_date_time;
		}
		$breakdown->working_status = $request->working_status;
		$breakdown->nature_of_problem = $request->nature_of_problem;
		$breakdown->is_contamination = $request->is_contamination;
		$breakdown->save();
		return redirect('admin/call/breakdown_maintenance')->with('flash_message', 'Breakdown Maintenance Entry created');
	}

	public function edit($id) {
		$this->availibility('Edit Breakdown Maintenance');
		$index['page'] = 'breakdown_maintenance';
		$index['breakdown'] = CallEntry::find($id);
		$index['hospitals'] = Hospital::pluck('name', 'id')->toArray();
		$index['serial_no'] = Equipment::where('hospital_id', $index['breakdown']->equipment->hospital_id)
			->pluck('sr_no', 'id')
			->toArray();
		$h_id = $index['breakdown']->equipment->hospital_id;
		$index['departments'] = Department::select('id', \DB::raw('CONCAT(short_name,"(",name,")") as department'))
			->whereHas('equipments', function ($q) use ($h_id) {
				$q->where('hospital_id', $h_id);
			})
			->pluck('department', 'id')
			->toArray();
		return view('call_breakdowns.edit', $index);
	}

	public function update(BreakdownCreateRequest $request, $id) {
		$breakdown = CallEntry::findOrFail($id);
		$breakdown->call_handle = $request->call_handle;
		$breakdown->equip_id = $request->equip_id;

		if ($breakdown->call_handle == 'external') {
			$breakdown->report_no = $request->report_no;
		}
		if (isset($request->call_register_date_time)) {
			$call_register_date_time = \Carbon\Carbon::parse($request->call_register_date_time);
			$breakdown->call_register_date_time = $call_register_date_time;
		}
		$breakdown->working_status = $request->working_status;
		$breakdown->nature_of_problem = $request->nature_of_problem;
		$breakdown->is_contamination = $request->is_contamination;
		$breakdown->save();
		return redirect('admin/call/breakdown_maintenance')->with('flash_message', 'Breakdown Maintenance Entry updated');
	}

	public function destroy($id) {
		$this->availibility('Delete Breakdown Maintenance');
		$breakdown = CallEntry::findOrFail($id);
		$breakdown->delete();
		return redirect('admin/call/breakdown_maintenance')->with('flash_message', 'Breakdown Maintenance Entry deleted');
	}

	public function ajax_unique_id(Request $request) {
		if ($request->ajax()) {
			$equipment = Equipment::where('id', $request->id)->first();
		}
		return response()->json(['success' => $equipment->toArray()], 200);
	}

	public function ajax_hospital_change(Request $request) {
		if ($request->ajax()) {
			$unique_id = Equipment::where('hospital_id', $request->id)
				->pluck('sr_no', 'id')
				->toArray();

			$department = Equipment::where('hospital_id', $request->id)
				->pluck('department', 'department')
				->toArray();
			$department = Department::select('id', \DB::raw('CONCAT(short_name,"(",name,")") as department'))
				->whereIn('id', $department)
				->pluck('department', 'id')->toArray();
		}
		return response()->json([
			'unique_id' => $unique_id,
			'department' => array_unique($department),

		], 200);
	}

	public function ajax_department_change(Request $request) {
		if ($request->ajax()) {
			if ($request->hospital_id && $request->hospital_id != "") {

				$unique_id = Equipment::where('department', $request->department)
					->where('hospital_id', $request->hospital_id)
					->pluck('sr_no', 'id')
					->toArray();
			} else {
				$unique_id = Equipment::where('department', $request->department)
					->pluck('sr_no', 'id')
					->toArray();
			}

		}
		return response()->json(['unique_id' => $unique_id], 200);
	}

	public function attend_call_get($id) {
		$breakdown_c = CallEntry::findOrFail($id);
		return response()->json(['b_m' => $breakdown_c->toArray()], 200);
	}
	public function attend_call(Request $request) {
		$breakdown = CallEntry::findOrFail($request->b_id);

		$validator = Validator::make($request->all(), [
			'call_attend_date_time' => 'required',
			'user_attended' => 'required',
			'service_rendered' => 'required',
			'remarks' => 'required',
			'working_status' => 'required',

		]);
		if ($validator->fails()) {
			return redirect()
				->back()
				->withInput($request->all())
				->withErrors($validator, 'attend_call');
		}

		$call_attend_date_time = \Carbon\Carbon::parse($request->call_attend_date_time);
		$breakdown->call_attend_date_time = $call_attend_date_time;
		$breakdown->user_attended = $request->user_attended;
		$breakdown->service_rendered = $request->service_rendered;
		$breakdown->remarks = $request->remarks;
		$breakdown->working_status = $request->working_status;
		$breakdown->save();

		return redirect('admin/call/breakdown_maintenance')->with('flash_message', 'Breakdown Call complete details saved ');
	}

	public function call_complete_get($id) {
		$breakdown_c = CallEntry::findOrFail($id);
		return response()->json(['b_m' => $breakdown_c->toArray()], 200);
	}

	public function call_complete(Request $request) {
		$breakdown = CallEntry::findOrFail($request->b_id);

		$validator = Validator::make($request->all(), [
			'call_complete_date_time' => 'required',
			'service_rendered' => 'required',
			'remarks' => 'required',
			'working_status' => 'required',
			'sign_of_engineer' => 'mimes:jpg,jpeg,png,pdf|file',
			'sign_stamp_of_incharge' => 'mimes:jpg,jpeg,png,pdf|file',
		]);
		if ($validator->fails()) {
			return redirect('admin/call/breakdown_maintenance')
				->withInput($request->all())
				->withErrors($validator, 'complete_call')
				->with('breakdown_c', $breakdown);
		}

		if ($request->hasFile('sign_of_engineer')) {
			$file = $request->file('sign_of_engineer');
			$name = 'engineer' . time() . $file->getClientOriginalName();

			if (!is_null($breakdown->sign_of_engineer) && file_exists('uploads/' . $breakdown->sign_of_engineer)) {
				unlink(public_path('uploads/') . $breakdown->sign_of_engineer);
			}
			$file->move(public_path('/uploads'), $name);
			$breakdown->sign_of_engineer = $name;
		}
		if ($request->hasFile('sign_stamp_of_incharge')) {
			$file = $request->file('sign_stamp_of_incharge');
			$name = 'incharge' . time() . $file->getClientOriginalName();

			if (!is_null($breakdown->sign_stamp_of_incharge) && file_exists('uploads/' . $breakdown->sign_stamp_of_incharge)) {
				unlink(public_path('uploads/') . $breakdown->sign_stamp_of_incharge);
			}
			$file->move(public_path('/uploads'), $name);
			$breakdown->sign_stamp_of_incharge = $name;
		}

		$call_complete_date_time = Carbon::parse($request->call_complete_date_time);
		$breakdown->call_complete_date_time = $call_complete_date_time;
		$breakdown->service_rendered = $request->service_rendered;
		$breakdown->remarks = $request->remarks;
		$breakdown->working_status = $request->working_status;
		$breakdown->save();
		return redirect('admin/call/breakdown_maintenance')
			->with('flash_message', 'Breakdown Call complete details saved ');
	}

	public static function availibility($method) {
		$r_p = Auth::user()->getPermissionsViaRoles()->pluck('name')->toArray();
		if (Auth::user()->hasPermissionTo($method)) {
			return true;
		} elseif (!in_array($method, $r_p)) {
			abort('401');
		} else {
			return true;
		}
	}
}
