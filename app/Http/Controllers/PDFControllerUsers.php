<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use  PDF;
use Illuminate\Support\Carbon;

class PDFControllerUsers extends Controller
{
    public function PDF($typeuser)
    {
        $users = User::select('users.id', 'users.nombre', 'users.email', 'role_type.name','role_type.name_screen','users.user_status')
            ->join('role_type', 'role_type.id', '=', 'users.id_role')
            ->where('role_type.name', '=', $typeuser)
            ->get();

        $pdf = PDF::loadView('reports/reportUsers', compact('users'))->setPaper('a4', 'landscape');

        $dateSystem = Carbon::now();
        $date = $dateSystem->format('Y-m-d');
        $Hour = date('h:i:s A');

        return $pdf->download('Reporte_Usuarios_Sistema' . $date . '_' . $Hour . '_' . '.pdf');
    }
}
