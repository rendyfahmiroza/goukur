<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function downloadFile($file){
        $path = public_path().'/upload/'.$file; // or storage_path() if needed
        $header = [
            'Content-Type' => 'application/*',
        ];
        return response()->download($path, $file, $header);
     }
}
