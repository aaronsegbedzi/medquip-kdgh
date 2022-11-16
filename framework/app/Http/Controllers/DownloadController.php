<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function mobileApp() {
        $file_path = public_path('kdghmobile.apk');
        return response()->download($file_path);
    }
}
