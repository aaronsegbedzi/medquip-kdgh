<?php

namespace App\Http\Controllers;

use App\CallEntry;
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

}
