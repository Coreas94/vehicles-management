<?php

namespace App\Http\Controllers;

use App\Imports\UsersVehiclesImport;
use App\Mail\ResponseMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        try {
            $import = new UsersVehiclesImport;
            Excel::import($import, $file);

            Mail::to('support@rebits.cl')->send(new ResponseMail('Se ha importado y procesado correctamente el archivo excel'));
            return response()->json(['success' => 'El archivo se ha subido correctamente y se ha procesado la importación.'], 200);

        } catch (\Exception $e) {
            Mail::to('support@rebits.cl')->send(new ResponseMail('Error en la importacion del archivo excel: ' . $e->getMessage()));
            return response()->json(['error' => 'Error en la importación: ' . $e->getMessage()], 500);

        }
    }
}
