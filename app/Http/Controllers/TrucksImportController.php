<?php

namespace App\Http\Controllers;

use App\Imports\TrucksImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TrucksImportController extends Controller
{
    public function showUploadForm()
    {
        return view('trucks_import');
    }

    public function upload(Request $request){
       $file = $request->file('file');

       Excel::import(new TrucksImport, $file);

       return back()->withStatus('Excel File uploaded successfully');
    }
}
