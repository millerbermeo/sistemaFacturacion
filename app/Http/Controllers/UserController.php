<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
            'estado' => 'required|string|max:50',
        ]);

        // Verificar si se ha subido una imagen
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/fotos', $imageName); // Guarda la imagen en 'storage/app/public/fotos'
            $validatedData['foto'] = $imageName; // Guarda el nombre de la imagen en la base de datos
        }

        $user = User::create([
            'nombre' => $validatedData['nombre'],
            'apellido' => $validatedData['apellido'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'identificacion' => $validatedData['identificacion'],
            'password' => Hash::make($validatedData['password']),
            'telefono' => $validatedData['telefono'] ?? null,
            'foto' => $validatedData['foto'] ?? null, // Almacena el nombre de la imagen
            'estado' => $validatedData['estado'],
        ]);

        return response()->json($user, 201);
    }

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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
            'estado' => 'sometimes|string|max:50',
        ]);

        // Verificar si se ha subido una nueva imagen
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/fotos', $imageName); // Guarda la nueva imagen

            // Eliminar la imagen anterior si existe
            if ($user->foto) {
                Storage::delete('public/fotos/' . $user->foto);
            }

            $validatedData['foto'] = $imageName; // Actualiza el nombre de la imagen en la base de datos
        }

        $user->update([
            'nombre' => $validatedData['nombre'] ?? $user->nombre,
            'apellido' => $validatedData['apellido'] ?? $user->apellido,
            'username' => $validatedData['username'] ?? $user->username,
            'email' => $validatedData['email'] ?? $user->email,
            'identificacion' => $validatedData['identificacion'] ?? $user->identificacion,
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
            'telefono' => $validatedData['telefono'] ?? $user->telefono,
            'foto' => $validatedData['foto'] ?? $user->foto, // Actualiza la imagen
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
