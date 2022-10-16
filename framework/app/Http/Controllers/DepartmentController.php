<?php

namespace App\Http\Controllers;

use App\Department;
use App\Hospital;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\DB;
use App\CallEntry;
use App\Equipment;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller {

	public function index() {
		$data['page'] = 'departments';
		$data['departments'] = Department::select('departments.*','hospitals.name as hospital')
		->join('hospitals', 'departments.hospital_id', 'hospitals.id')->withCount('equipments')->get();
		return view('departments.index', $data);
	}

	public function create() {
		$data['page'] = 'departments';
		$data['hospitals'] = Hospital::pluck('name', 'id')->toArray();
		return view('departments.create', $data);
	}

	public function customer() {
		$id = Auth::user()->hospital_id;
		$data['page'] = 'my_departments';
		$data['departments'] = Department::where('hospital_id', $id)->get();
		return view('departments.customer', $data);
	}

	public function view($id) {
		$index['page'] = 'my_departments';
		$index['department'] = Department::findOrFail($id);
		$index['counts'] = collect(DB::select("SELECT count(case when c.working_status = 'pending' OR c.working_status IS NULL then 1 end) AS pending, count(case when c.working_status = 'working' then 1 end) AS working, count(case when c.working_status = 'not working' then 1 end) AS not_working, count(*) AS total FROM equipments e LEFT JOIN call_entries c ON e.id = c.equip_id AND c.id = (SELECT MAX(id) FROM call_entries d WHERE d.equip_id = c.equip_id) WHERE e.department = ?", [$id]))->first();
		$index['equipments'] = DB::select("SELECT e.id, e.name, e.short_name, e.sr_no, IFNULL(c.working_status,'pending') AS 'working_status', c.call_register_date_time, c.call_attend_date_time, c.call_complete_date_time FROM equipments e LEFT JOIN call_entries c ON e.id = c.equip_id AND c.id = (SELECT MAX(id) FROM call_entries d WHERE d.equip_id = c.equip_id) WHERE e.department = ? ORDER BY c.call_complete_date_time DESC", [$id]);
		$index['calls'] = CallEntry::select('*')->join('equipments', 'equipments.id', 'call_entries.equip_id')->where('equipments.department', $id)->get(); 
		return view('departments.view', $index);
	}

	public function store(DepartmentRequest $request) {
		$department = new Department;
		$department->name = $request->name;
		$department->short_name = $request->short_name;
		$department->hospital_id = $request->hospital_id;
		$department->save();

		return redirect()->route('departments.index')
			->with('flash_message',
				'Department "' . $department->name . '" Created!');
	}

	public function edit($id) {
		$data['page'] = 'departments';
		$data['department'] = Department::findOrFail($id);
		$data['hospitals'] = Hospital::pluck('name', 'id')->toArray();
		return view('departments.edit', $data);
	}

	public function update(DepartmentRequest $request, $id) {
		$department = Department::findOrFail($id);
		$department->name = $request->name;
		$department->short_name = $request->short_name;
		$department->hospital_id = $request->hospital_id;
		$department->save();

		return redirect()->route('departments.index')
			->with('flash_message',
				'Department "' . $department->name . '" updated!');
	}

	public function destroy($id) {
		$department = Department::findOrFail($id);
		$department->delete();

		return redirect()->route('departments.index')
			->with('flash_message',
				'Department "' . $department->name . '" deleted!');
	}

	public function ajax_departments($id) {
		$departments = Department::where('hospital_id', $id)->pluck('name', 'id')->toArray();
        if ($departments){
            foreach ($departments as $key => $department) {
                $payload[] = array(
                    'id' => $key,
                    'text' => $department
                );
            }
        } else {
            $payload = array();
        }
        return response()->json(array('results'=>$payload), 200);
	}

	public static function recursive($yourString) {
		$result = "";
		if (strpos($yourString, " ") === false) {
			$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U",
				" ", "-", "_");
			$yourString = str_replace($vowels, "", $yourString);
			$check = Department::where('short_name', $yourString)->first();

			if (is_null($check)) {
				return $yourString;
			}
			$only_one_word = substr($yourString, 0, 1);
			$only_one_word .= substr($yourString, 1, 1);
			$check = Department::where('short_name', $only_one_word)->first();
		} else {
			$words = explode(" ", $yourString);
			$first_char_after_space = substr($words[0], 0, 1);
			$first_char_after_space .= substr($words[1], 0, 1);
			if (array_key_exists(2, $words)) {
				$first_char_after_space .= substr($words[2], 0, 1);
			}
			$check_first_two_char_of_words = Department::where('short_name', $first_char_after_space)->first();
			if ($check_first_two_char_of_words == "") {
				$result = $first_char_after_space;
			}
			if ($result == "") {
				$vowels = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ", "-", "_");
				$yourString = str_replace($vowels, "", $yourString);
				$count = 1;
				for ($i = 1; $i <= strlen($yourString); $i++) {
					$first_char = substr($yourString, 0, 1);
					$first_char .= substr($yourString, $i, 1);
					$check_first_two_char = Department::where('short_name', $first_char)->first();

					if ($count < strlen($yourString)) {
						if ($check_first_two_char == "") {
							$result = $first_char;
							break;
						}
					}

					$count++;
				}
			}
		}
		return $result;
	}
}
