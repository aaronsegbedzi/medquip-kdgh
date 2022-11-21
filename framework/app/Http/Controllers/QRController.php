<?php

namespace App\Http\Controllers;

use App\Department;
use App\Equipment;
use App\Hospital;
use PDF;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function post(Request $request) {

        $index['hospital'] = Hospital::findorfail($request->qr_hospital);
       
        $equipments = Equipment::select('id','sr_no','name','model')->where('hospital_id', $request->qr_hospital);

        if (isset($request->qr_department) && !empty($request->qr_department)) {
            $equipments->where('department', $request->qr_department);
        }

        if ($equipments->count()) {

            $index['equipments'] = $equipments->get();

            $pdf = PDF::loadView('equipments.export_qr', $index)->setPaper('a4', 'portrait');
        
            return $pdf->download(time() . '_equipment_qr_codes.pdf');

            // Output the generated PDF to Browser
            // return $pdf->stream();

        } else {

            return redirect('admin/equipments')->with('flash_message', 'No Equipments to Generate Qr Codes');

        }

    }

}
