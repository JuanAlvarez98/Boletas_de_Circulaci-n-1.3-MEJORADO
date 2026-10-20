<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserRoleController extends Controller
{
    /**
     * Listar los usuarios del sistema y sus roles asignados.
     */
    public function index(): View
    {
        $users = User::with('roles')->get();

        return view('users.index', compact('users'));
    }

    /**
     * Mostrar el panel para editar los roles de un usuario.
     */
    public function edit(User $user): View
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray(); // IDs de roles que ya tiene el usuario

        return view('users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Guardar los roles asignados al usuario en la base de datos.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ]);

        $rolesToSync = $request->input('roles', []);

        // Regla de seguridad: Impedir quitar el rol de administrador si es el único administrador del sistema
        if ($user->hasRole('admin') && ! in_array(Role::where('slug', 'admin')->first()->id, $rolesToSync)) {
            $adminRoleId = Role::where('slug', 'admin')->first()->id;

            // Contar cuántos administradores activos quedan
            $otherAdminsCount = User::whereHas('roles', function ($query) use ($adminRoleId) {
                $query->where('role_id', $adminRoleId);
            })->where('id', '!=', $user->id)->count();

            if ($otherAdminsCount === 0) {
                return back()->withErrors(['error' => 'No puedes revocar el rol de Administrador a este usuario. Debe existir al menos un administrador activo en el sistema.']);
            }
        }

        // Sincronizar los roles en la tabla pivot role_user
        $user->roles()->sync($rolesToSync);

        return redirect()->route('users.index')->with('status', 'Roles de usuario actualizados correctamente.');
    }
}
