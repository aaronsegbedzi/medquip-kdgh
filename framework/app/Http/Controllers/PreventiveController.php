<?php

namespace App\Http\Controllers;
use App\CallEntry;
use App\Department;
use App\Equipment;
use App\Hospital;
use App\Http\Requests\PreventiveCreateRequest;
use App\ServiceRenderedItem;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class PreventiveController extends Controller {

	public function index() {
		$this->availibility('View Preventive Maintenance');
		$index['page'] = 'preventive_maintenance';
		$index['p_maintenance'] = CallEntry::where('call_type', 'preventive')->latest()->get();
		$index['services'] = ServiceRenderedItem::pluck('new_item', 'new_item')->toArray();
		$index['users'] = User::whereHas('roles', function ($query) {
			return $query->where('name', 'Engineer');
		})->pluck('name', 'id')->toArray();
		return view('call_preventive.index', $index);
	}

	public function create() {
		$this->availibility('Create Preventive Maintenance');
		$index['page'] = 'preventive_maintenance';
		$index['serial_no'] = Equipment::pluck('sr_no', 'id')->toArray();
		$index['departments'] = Department::select('id', \DB::raw('CONCAT(short_name,"(",name,")") as department'))->pluck('department', 'id')->toArray();
		$index['hospitals'] = Hospital::withTrashed()->pluck('name', 'id')->toArray();
		return view('call_preventive.create', $index);
	}

	public function store(PreventiveCreateRequest $request) {
		$preventive = new CallEntry;
		$preventive->call_handle = $request->call_handle;
		$preventive->call_type = 'preventive';
		$preventive->equip_id = $request->equip_id;
		$preventive->user_id = Auth::id();
		$report_no = CallEntry::where('call_handle', 'internal')->count();
		if ($preventive->call_handle == 'external') {
			$preventive->report_no = $request->report_no;
		} elseif ($preventive->call_handle == 'internal') {
			$preventive->report_no = $report_no + 1;
		}
		if (isset($request->call_register_date_time)) {
			$call_register_date_time = Carbon::parse($request->call_register_date_time);
			$preventive->call_register_date_time = $call_register_date_time;
		}
		if (isset($request->next_due_date)) {
			$next_due_date = Carbon::parse($request->next_due_date);
			$preventive->next_due_date = $next_due_date;
		}
		$preventive->working_status = $request->working_status;
		$preventive->nature_of_problem = $request->nature_of_problem;
		$preventive->is_contamination = $request->is_contamination;
		$preventive->save();
		return redirect('admin/call/preventive_maintenance')->with('flash_message', 'Preventive Maintenance Entry created');
	}

	public function edit($id) {
		$this->availibility('Edit Preventive Maintenance');
		$index['page'] = 'preventive_maintenance';
		$index['preventive'] = CallEntry::find($id);
		$index['serial_no'] = Equipment::withTrashed()->where('hospital_id', $index['preventive']->equipment->hospital_id)
			->pluck('sr_no', 'id')
			->toArray();
		$h_id = $index['preventive']->equipment->hospital_id;
		$index['departments'] = Department::select('id', \DB::raw('CONCAT(short_name,"(",name,")") as department'))
			->whereHas('equipments', function ($q) use ($h_id) {
				$q->where('hospital_id', $h_id);
			})
			->pluck('department', 'id')
			->toArray();
		$index['hospitals'] = Hospital::withTrashed()->pluck('name', 'id')->toArray();
		return view('call_preventive.edit', $index);
	}

	public function update(PreventiveCreateRequest $request, $id) {
		$preventive = CallEntry::findOrFail($id);
		$preventive->call_handle = $request->call_handle;
		$preventive->equip_id = $request->equip_id;

		if ($preventive->call_handle == 'external') {
			$preventive->report_no = $request->report_no;
		}
		if (isset($request->call_register_date_time)) {
			$call_register_date_time = \Carbon\Carbon::parse($request->call_register_date_time);
			$preventive->call_register_date_time = $call_register_date_time;
		}
		if (isset($request->next_due_date)) {
			$next_due_date = Carbon::parse($request->next_due_date);
			$preventive->next_due_date = $next_due_date;
		}
		$preventive->working_status = $request->working_status;
		$preventive->nature_of_problem = $request->nature_of_problem;
		$preventive->is_contamination = $request->is_contamination;
		$preventive->save();
		return redirect('admin/call/preventive_maintenance')->with('flash_message', 'preventive Maintenance Entry updated');
	}

	public function destroy($id) {
		$this->availibility('Delete Preventive Maintenance');
		$preventive = CallEntry::findOrFail($id);

		if ($preventive->sign_of_engineer != null && file_exists('uploads/' . $preventive->sign_of_engineer)) {
			unlink(public_path('uploads/') . $preventive->sign_of_engineer);
		}

		$preventive->delete();
		return redirect('admin/call/preventive_maintenance')->with('flash_message', 'Preventive Maintenance Entry deleted');
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
		$preventive_c = CallEntry::findOrFail($id);
		$new_item = ServiceRenderedItem::select('new_item')->get();
		return response()->json(['p_m' => $preventive_c->toArray(), 'n_i' => $new_item], 200);
	}

	public function attend_call(Request $request) {
		$preventive = CallEntry::findOrFail($request->b_id);

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
		$preventive->call_attend_date_time = $call_attend_date_time;
		$preventive->user_attended = $request->user_attended;
		$preventive->user_attended_2 = $request->user_attended_2;
		$preventive->service_rendered = $request->service_rendered;
		$preventive->remarks = $request->remarks;
		$preventive->working_status = $request->working_status;
		$preventive->save();

		return redirect('admin/call/preventive_maintenance')->with('flash_message', 'preventive Call complete details saved ');
	}

	public function call_complete_get($id) {
		$preventive_c = CallEntry::findOrFail($id);
		$new_item = ServiceRenderedItem::select('new_item')->get();
		return response()->json(['p_m' => $preventive_c->toArray(), 'n_i' => $new_item], 200);
	}

	public function call_complete(Request $request) {
		$preventive = CallEntry::findOrFail($request->b_id);
		if ($request->service_rendered == 'add_new') {
			$input = $request->except('service_rendered');
		} else {
			$input = $request->all();
		}
		$validator = Validator::make($input, [
			'call_complete_date_time' => 'required',
			'next_due_date' => 'required|date',
			'service_rendered' => 'required',
			'remarks' => 'required',
			'working_status' => 'required',
			'sign_of_engineer' => 'mimes:jpg,jpeg,png,pdf',
			'sign_stamp_of_incharge' => 'mimes:jpg,jpeg,png,pdf',
		]);
		if ($validator->fails()) {
			return redirect()
				->back()
				->withInput($request->all())
				->withErrors($validator, 'complete_call');
		}
		if ($request->hasFile('sign_of_engineer')) {
			$file = $request->file('sign_of_engineer');
			$name = 'engineer' . time() . $file->getClientOriginalName();

			if (!is_null($preventive->sign_of_engineer) && file_exists('uploads/' . $preventive->sign_of_engineer)) {
				unlink(public_path('uploads/') . $preventive->sign_of_engineer);
			}
			$file->move(public_path('/uploads'), $name);
			$preventive->sign_of_engineer = $name;
		}
		if ($request->hasFile('sign_stamp_of_incharge')) {
			$file = $request->file('sign_stamp_of_incharge');
			$name = 'incharge' . time() . $file->getClientOriginalName();

			if (!is_null($preventive->sign_stamp_of_incharge) && file_exists('uploads/' . $preventive->sign_stamp_of_incharge)) {
				unlink(public_path('uploads/') . $preventive->sign_stamp_of_incharge);
			}
			$file->move(public_path('/uploads'), $name);
			$preventive->sign_stamp_of_incharge = $name;
		}

		$call_complete_date_time = Carbon::parse($request->call_complete_date_time);
		$preventive->call_complete_date_time = $call_complete_date_time;
		$next_due_date = Carbon::parse($request->next_due_date);
		$preventive->next_due_date = $next_due_date;
		$preventive->service_rendered = $request->service_rendered;
		$preventive->remarks = $request->remarks;
		$preventive->working_status = $request->working_status;
		$preventive->save();
		return redirect('admin/call/preventive_maintenance')
			->with('flash_message', 'preventive Call complete details saved ')
			->with('breakdown_p', $preventive);
	}

	public function ajax_new_item_post(Request $request) {
		if ($request->ajax()) {
			if ($request->new_item != "") {
				$new_item_db = new ServiceRenderedItem;
				$new_item_db->new_item = $request->new_item;
				$new_item_db->save();
				return response()->json(['new_item_db' => $new_item_db], 200);
			} else {
				return response()->json(['new_item_db' => ''], 200);
			}
		}

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
