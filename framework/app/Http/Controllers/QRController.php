<?php

namespace App\Http\Controllers;

use App\Equipment;
use PDF;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function post(Request $request) {
       
        $index['equipments'] = Equipment::select('*')->get();
        // $index['equipments'] = Equipment::select('*')->where('hospital_id', $request->qr_hospital)->get();

        // if (isset($request->qr_department) && !empty($request->qr_department)) {
        //     $index['equipments']->where('department', $request->qr_department);
        // }

        // $pdf = PDF::loadView('equipments.export_qr', $index)->setPaper('a4', 'portrait');
        
        // return $pdf->download(time() . '_equipment.pdf');

        return view('equipments.export_qr', $index);

    }

}
