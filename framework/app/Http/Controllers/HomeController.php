<?php

namespace App\Http\Controllers;

use App\Calibration;
use App\CallEntry;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$index['page'] = '/home';
		$breakdown_totals = $preventive_totals = $total_days = [];

		$last_thirty_days = date('Y-m-d', strtotime('-30 days'));

		$breakdown = CallEntry::select('*', DB::raw('COUNT(*) as total'), DB::raw('DATE(created_at) as date'))
			->where('call_type', 'breakdown')
			->whereDate('created_at', '>=', $last_thirty_days)
			->groupBy('date')->get();

		$preventive = CallEntry::select('*', DB::raw('COUNT(*) as total'), DB::raw('DATE(created_at) as date'))
			->where('call_type', 'preventive')
			->whereDate('created_at', '>=', $last_thirty_days)
			->groupBy('date')->get();

		for ($i = 30; $i >= 0; $i--) {
			$total_days[] = date("Y-m-d", strtotime('-' . $i . ' days'));
		}

		foreach ($total_days as $key => $v) {
			foreach ($breakdown as $key => $b) {
				if ($b->date == $v) {
					array_push($breakdown_totals, $b->total);
				} else {
					array_push($breakdown_totals, 0);
				}
			}

			foreach ($preventive as $key => $p) {
				if ($p->date == $v) {
					array_push($preventive_totals, $p->total);
				} else {
					array_push($preventive_totals, 0);
				}
			}
		}

		$index['total_days_array'] = $total_days;
		$index['breakdown'] = $breakdown_totals;
		$index['preventive'] = $preventive_totals;
		// dd($index);
		return view('home', $index);
	}

	/**
	 * Get calendar entries for dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function calendar() {

		$breakdowns = CallEntry::select('call_entries.*', 'equipments.name', 'equipments.unique_id')
			->join('equipments', 'equip_id', '=', 'equipments.id')
			->where('call_type', 'breakdown')->get();

		foreach ($breakdowns as $key => $breakdown) {
			$entries[] = array(
				'title' => $breakdown['unique_id'].' ('.$breakdown['name'].')',
				'start' => $breakdown['call_register_date_time'],
				'url' => url('/equipments/history/'.$breakdown['equip_id']),
				'description' => $breakdown['nature_of_problem'],
				'color' => '#00c0ef'
			);
		}

		$preventives = CallEntry::select('call_entries.*', 'equipments.name', 'equipments.unique_id')
			->join('equipments', 'equip_id', '=', 'equipments.id')
			->where('call_type', 'preventive')->get();

		foreach ($preventives as $key => $preventive) {

			$entries[] = array(
				'title' => $preventive['unique_id'].' ('.$preventive['name'].')',
				'start' => $preventive['next_due_date'],
				'url' => url('/equipments/history/'.$preventive['equip_id']),
				'color' => '#3d9970'
			);

			$entries[] = array(
				'title' => $preventive['unique_id'].' ('.$preventive['name'].')',
				'start' => $preventive['call_register_date_time'],
				'url' => url('/equipments/history/'.$preventive['equip_id']),
				'color' => '#3d9970'
			);

		}

		$calibrations = Calibration::select('calibrations.*', 'equipments.name', 'equipments.unique_id')
			->join('equipments', 'equip_id', '=', 'equipments.id')->get();

		foreach ($calibrations as $key => $calibration) {
			$entries[] = array(
				'title' => $calibration['unique_id'].' ('.$calibration['name'].')',
				'start' => $calibration['due_date'],
				'url' => url('/equipments/history/'.$calibration['equip_id']),
				'color' => '#919191'
			);
			$entries[] = array(
				'title' => $calibration['unique_id'].' ('.$calibration['name'].')',
				'start' => $calibration['date_of_calibration'],
				'url' => url('/equipments/history/'.$calibration['equip_id']),
				'color' => '#919191'
			);
		}

		return response()->json($entries);

	}

}
