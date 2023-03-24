<?php

namespace App\Http\Controllers;

use App\Imports\RouteImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RoutesImportController extends Controller
{
    public function showUploadForm()
    {
        return view('routes_import');
    }

    public function upload(Request $request){
       $file = $request->file('file');

       Excel::import(new RouteImport, $file);

       return back()->withStatus('Excel File uploaded successfully');
    }
}
