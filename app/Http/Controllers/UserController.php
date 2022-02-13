<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Role;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;;

class UserController extends Controller
{
    public function getUsers(Request $request)
    {
        $search = $request->search;
        $criterion = $request->criterion;

        if ($search == '') {
            $users = DB::table('users')
                ->select('users.id', 'users.nombre', 'users.email', 'role_type.name_screen','role_type.id AS id_role','users.user_status')
                ->join('role_type', 'role_type.id', '=', 'users.id_role')
                ->orderBy('users.id', 'asc')
                ->paginate(3);
        } else {
            if ($criterion == 'id') {
                $users = DB::table('users')
                    ->select('users.id', 'users.nombre', 'users.email', 'role_type.name_screen','users.user_status')
                    ->join('role_type', 'role_type.id', '=', 'users.id_role')
                    ->where('users.id', '=', $search)
                    ->orderBy('users.id', 'asc')
                    ->paginate(3);
            }else {
                $users = DB::table('users')
                    ->select('users.id', 'users.nombre', 'users.email', 'role_type.name_screen','users.user_status')
                    ->join('role_type', 'role_type.id', '=', 'users.id_role')
                    ->where('users.' . $criterion, 'like', '%' . $search . '%')
                    ->orderBy('users.id', 'asc')
                    ->paginate(3);
            }
        }
        return [
            'pagination' => [
                'total'        => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page'     => $users->perPage(),
                'last_page'    => $users->lastPage(),
                'from'         => $users->firstItem(),
                'to'           => $users->lastItem(),
            ],
            'users' => $users
        ];
    }

    public function getRolesSelect()
    {
            $roles = Role::all();
            return ['roles' => $roles];
    }


    public function store(Request $request)
    {
        $messages = [
            'id.required' => 'La cedula es requerida',
            'nombre.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.unique' => 'Ya existe un usuario con ese correo',
            'password.required' => 'La contraseña es requerida',
            'id_role.required' => 'El role es requerido',
        ];

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre' => 'required|string',
            'email' => 'required|unique:users',
            'password' => 'required',
            'id_role' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 404);
        }

        $date = Carbon::now();
        $user = User::create([
            'id' => $request->id,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->passowrd),
            'created_at' => $date->format('Y-m-d'),
            'id_role' => $request->id_role,
            'user_status' => 1
        ]);

        return response()->json('Se ha registrado con exito el usuario', 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user != null) {
            $user->delete();
            return response()->json('Usuario eliminado con exito', 200);
        } else {
            return response()->json('No existe un usuario con esa identificacion en nuestros registros', 404);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'email.required' => 'El email es requerido',
            'email.unique' => 'Ya existe un usuario con ese correo',
            'id_role.required' => 'El role es requerido',
        ];

        if ($user != null) {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string',
                'email' => 'required|unique:users',
                'id_role' => 'required'
            ], $messages);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }

            $user->nombre = $request->nombre;
            $user->email = $request->email;
            $user->id_role = $request->id_role;
            $user->update();
            return response()->json('Se ha actualizo con exito el usuario', 200);
        } else {
            return response()->json(['No existe un usuario con esa identificacion en nuestros registros'], 404);
        }
    }

    public function updateStateUser(Request $request,$id){

        $state = '';
        $user = User::find($id);
        if($user != null){
            if($request->user_status == 1){
                $state = 'Activado';
            }else if( $request->user_status == 0){
                $state = 'Inactivado';
            }
            $user->user_status =  $request->user_status;
            $user->update();
            return response()->json('El usuario ha sido '.$state, 200);
        }
    }
}
