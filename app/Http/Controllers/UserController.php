<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Listar usuarios
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $users = User::all();
        return response()->json($users);
    }

    // Mostrar un usuario específico
    public function show($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        return response()->json($user);
    }

    // Crear un nuevo usuario
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'identificacion' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'required|string|max:50',
        ]);

        $user = User::create([
            'nombre' => $validatedData['nombre'],
            'apellido' => $validatedData['apellido'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'identificacion' => $validatedData['identificacion'],
            'password' => Hash::make($validatedData['password']),
            'telefono' => $validatedData['telefono'] ?? null,
            'estado' => $validatedData['estado'],
        ]);

        return response()->json($user, 201);
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nombre' => 'sometimes|string|max:255',
            'apellido' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:users,username,' . $id,
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'identificacion' => 'sometimes|string|max:255|unique:users,identificacion,' . $id,
            'password' => 'sometimes|string|min:6',
            'telefono' => 'nullable|string|max:20',
            'estado' => 'sometimes|string|max:50',
        ]);

        $user->update([
            'nombre' => $validatedData['nombre'] ?? $user->nombre,
            'apellido' => $validatedData['apellido'] ?? $user->apellido,
            'username' => $validatedData['username'] ?? $user->username,
            'email' => $validatedData['email'] ?? $user->email,
            'identificacion' => $validatedData['identificacion'] ?? $user->identificacion,
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
            'telefono' => $validatedData['telefono'] ?? $user->telefono,
            'estado' => $validatedData['estado'] ?? $user->estado,
        ]);

        return response()->json($user);
    }

    // Eliminar un usuario
    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
