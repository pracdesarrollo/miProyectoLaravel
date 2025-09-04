<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth()->user();

        if ($user->hasRole('admin') || $user->hasRole('gerente')) {
            
            $query = $request->input('query');

            $users = User::query();

            if ($query) {
                $users->where('name', 'like', "%{$query}%")
                  ->orWhere('last_name', 'like', "%{$query}%")
                  ->orWhere('role', 'like', "%{$query}%");
            }

            $users = $users->get();


           return view('users.index', compact('users'));

           
        }
        // Si el usuario no es un 'admin', puedes redirigirlo a otra página
        return redirect()->route('dashboard')->with('error', 'No tienes permisos para ver esta página.');
    

    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
{
    // 1. Validation
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|string|exists:roles,name', // Validate that the role exists
    ]);

    // 2. Create the new user
    $user = User::create([
        'name' => $validatedData['name'],
        'last_name' => $validatedData['last_name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
    ]);

    // 3. Assign the role using Spatie's method
    $user->assignRole($validatedData['role']);

    // 4. Redirect with a success message
    return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
}

    public function show(User $user)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('gerente')) {
            return view('users.show', compact('user'));
        }

        // Opcional: Redireccionar o mostrar un error si el usuario no tiene permisos
        return redirect()->route('dashboard')->with('error', 'No tienes permisos para ver este usuario.');

    }

    public function edit(User $user)
{
    if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('gerente')) {
        $roles = \Spatie\Permission\Models\Role::pluck('name');
        $userRole = $user->getRoleNames()->first();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }
    return redirect()->route('dashboard')->with('error', 'No tienes permisos para editar este usuario.');
}


    

    public function destroy(User $user)
    {
        // Obtiene el usuario autenticado
        $authenticatedUser = Auth::user();
    
       // Verifica si el usuario actual tiene el rol de 'admin'
       if (Auth::user()->hasRole('admin') ) {
           $user->delete();
           // Redirecciona a la lista de usuarios con un mensaje de éxito
           return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
        }

        // Si el usuario no es 'admin', lo redirecciona con un mensaje de error
        return redirect()->route('dashboard')->with('error', 'No tienes permisos para eliminar este usuario.');
    }


    public function update(Request $request, User $user)
{
    if (Auth::user()->hasRole('admin')) {
        // 1. Validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|exists:roles,name', // Validate that the role exists
        ]);

        // 2. Update the user's basic information
        $user->name = $validatedData['name'];
        $user->last_name = $validatedData['last_name'];
        $user->email = $validatedData['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        // 3. Sync the user's role with the Spatie package
        $user->syncRoles($validatedData['role']);
        
        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    return redirect()->route('dashboard')->with('error', 'No tienes permisos para editar este usuario.');
}

}

    
   
    

