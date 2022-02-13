<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class ExcelControllerUsers extends Controller
{
    public function export(){
        $dateSystem = Carbon::now();
        $date = $dateSystem->format('Y-m-d');
        $Hour = date('h:i:s A');
        return Excel::download(new UsersExport, 'Reporte_Usuarios_Sistema' . $date . '_' . $Hour . '_' .'.xlsx');
    }
}
