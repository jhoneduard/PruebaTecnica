<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Role;
use Database\Seeders\RoleType;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function getRoles(Request $request)
    {
        $search = $request->search;
        $criterion = $request->criterion;

        if ($search == '') {
            $roles = Role::orderBy('id', 'asc')->paginate(3);
        } else {
            if ($criterion == 'id') {
                $roles = Role::where('id', '=', $search)->orderBy('id', 'asc')->paginate(3);
            } else {
                $roles = Role::where($criterion, 'like', '%' . $search . '%')->orderBy('id', 'asc')->paginate(3);
            }
        }
        return [
            'pagination' => [
                'total'        => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page'     => $roles->perPage(),
                'last_page'    => $roles->lastPage(),
                'from'         => $roles->firstItem(),
                'to'           => $roles->lastItem(),
            ],
            'roles' => $roles
        ];
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'El nombre es requerido',
            'name_screen.required' => 'El nombre de pantalla es requerido',
            'name.unique' => 'Ya existe un rol con ese nombre',
            'name_screen.unique' => 'Ya existe un rol con ese nombre de pantalla'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:role_type',
            'name_screen' => 'required|string|unique:role_type'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 404);
        }
        $role = Role::create([
            'name' => $request->name,
            'name_screen' => $request->name_screen,
        ]);

        return response()->json('Se ha registrado con exito el rol ' . $role->name_screen, 200);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $messages = [
            'name.required' => 'El nombre es requerido',
            'name_screen.required' => 'El nombre de pantalla es requerido'
        ];

        if ($role != null) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'name_screen' => 'required|string'
            ], $messages);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 404);
            }
            $role->name = $request->name;
            $role->name_screen = $request->name_screen;
            $role->update();
            return response()->json('Se ha actualizado con exito el rol ' . $role->name_screen, 200);
        }
    }

    public function destroy($id)
    {
        $role = Role::find($id);

        if ($role != null) {
            $countRol = DB::table('users')->where('id_role', $id)->count();
            if ($countRol == 0) {
                $role->delete();
                return response()->json('El rol fue exitosamente eliminado ', 200);
            } else {
                return response()->json('El rol no se puede eliminar, debido a que el rol tiene unos usuarios asociados. ', 404);
            }
        } else {
            return response()->json('No existe un rol con esa identificacion en nuestros registros. ', 404);
        }
    }
}
