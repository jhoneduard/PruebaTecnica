<?php

namespace App\Exports;

use App\Models\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Cedula',
            'Nombre',
            'Email',
            'Rol',
        ];
    }
    public function collection()
    {
        $users = User::select('users.id', 'users.nombre', 'users.email', 'role_type.name_screen')
            ->join('role_type', 'role_type.id', '=', 'users.id_role')
            ->get();         
        return $users;

    }
}