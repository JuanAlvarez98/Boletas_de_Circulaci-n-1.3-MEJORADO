<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Listar todos los roles del sistema.
     */
    public function index(): View
    {
        $roles = Role::withCount('users')->get();

        return view('roles.index', compact('roles'));
    }

    /**
     * Mostrar el formulario para crear un rol.
     */
    public function create(): View
    {
        return view('roles.create');
    }

    /**
     * Guardar el nuevo rol en la base de datos.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'description' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe un rol con este nombre.',
        ]);

        Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Generar el identificador slug automáticamente
            'description' => $request->description,
        ]);

        return redirect()->route('roles.index')->with('status', 'Rol creado exitosamente.');
    }

    /**
     * Mostrar el formulario para editar el rol.
     */
    public function edit(Role $role): View
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Actualizar los datos del rol en la base de datos.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,'.$role->id],
            'description' => ['nullable', 'string', 'max:500'],
        ], [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.unique' => 'Ya existe otro rol con este nombre.',
        ]);

        // Evitar cambiar el slug del rol admin de forma accidental
        $slug = ($role->slug === 'admin') ? 'admin' : Str::slug($request->name);

        $role->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);

        return redirect()->route('roles.index')->with('status', 'Rol actualizado exitosamente.');
    }

    /**
     * Eliminar un rol del sistema.
     */
    public function destroy(Role $role): RedirectResponse
    {
        // Regla de seguridad: Impedir eliminar el rol administrador
        if ($role->slug === 'admin') {
            return back()->withErrors(['error' => 'No se puede eliminar el rol de Administrador principal del sistema.']);
        }

        // Desvincular usuarios asociados antes de borrar
        $role->users()->detach();
        $role->delete();

        return redirect()->route('roles.index')->with('status', 'Rol eliminado exitosamente.');
    }
}
