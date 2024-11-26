<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserCreateFormRequest;
use App\Http\Requests\UserUpdateFormRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;
use App\Service\DiscordWebhookService;
use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Events\UserDeleted;
use App\Events\UserRestore;
use App\Events\ErrorOccurred;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::paginate(10);
            return view('users.index', compact('users'));
        } catch (\Exception $e) {

            event(new ErrorOccurred('Error en el método index', $e->getMessage()));

            return redirect()->route('usuarios.index')->with('error', 'Error al cargar los usuarios.');
        }
    }

    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles
        return view('users.save', compact('roles'));
    }

    public function store(UserCreateFormRequest $request)
    {
        try{
            $user = User::create([
                'names' => $request->names,
                'lastnames' => $request->lastnames,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'address' => $request->address,
                'role' => $request->role ?? 'user',
            ]);
    
            if ($request->role) {
                $user->roles()->attach($request->role);
            }
    
            event(new UserCreated($user));
    
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');

        } catch (\Exception $e){

            event(new ErrorOccurred('Error al crear el usuario', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Error al crear el usuario.');
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return view('users.show', compact('user'));
        } catch (\Exception $e) {

            event(new ErrorOccurred('Error en el método show', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Usuario no encontrado.');
        }
    }

    public function edit(string $id)
    {
        try {
            $roles = Role::all();
            $user = User::findOrFail($id);

            return view('users.save', compact('user', 'roles'));
        } catch (\Exception $e) {

            event(new ErrorOccurred('Error en el método edit', $e->getMessage()));
            return redirect()->route('usuarios.index')->with('error', 'Error al cargar el usuario.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    
     public function update(UserUpdateFormRequest $request, string $id)
     {
         try {
             $user = User::findOrFail($id);
             
             $user->names = $request->input('names');
             $user->lastnames = $request->input('lastnames');
             $user->email = $request->input('email');
     
             if ($request->input('password')) {
                 $user->password = bcrypt($request->input('password'));
             }

             $user->address = $request->input('address');

             if ($request->input('role')) {
                $user->roles()->sync([$request->input('role')]);
            }
     
             $user->save();
     
             event(new UserUpdated($user));
     
             return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
         } catch (\Exception $e) {

            event(new ErrorOccurred('Error al actualizar el usuario', $e->getMessage()));

             return redirect()->route('usuarios.index')->with('error', 'Error al actualizar el usuario.');
         }
     }
     

    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            event(new UserDeleted($user));
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {

            event(new ErrorOccurred('Error al eliminar el usuario', $e->getMessage()));

            return redirect()->route('usuarios.index')->with('error', 'Error al eliminar el usuario.');
        }
    }

    public function trashed()
    {
        try {
            $users = User::onlyTrashed()->paginate(10);
            return view('users.trashed', compact('users'));
        } catch (\Exception $e) {

            event(new ErrorOccurred('Error en el método trashed', $e->getMessage()));

            return redirect()->route('usuarios.index')->with('error', 'Error al cargar los usuarios eliminados.');
        }
    }

    public function restore(string $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore();

            event(new UserRestore($user));
            return redirect()->route('usuarios.index')->with('success', 'Usuario restaurado exitosamente.');
        } catch (\Exception $e) {

            event(new ErrorOccurred('Error al restaurar el usuario', $e->getMessage()));

            return redirect()->route('usuarios.index')->with('error', 'Error al restaurar el usuario.');
        }
    }
}
