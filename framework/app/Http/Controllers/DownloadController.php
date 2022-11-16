<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function mobileApp() {
        $headers = array(
            'Content-Type: application/vnd.android.package-archive',
        );
        $file_path = public_path('kdghmobile.apk');
        return response()->download($file_path,null,$headers);
    }
}
