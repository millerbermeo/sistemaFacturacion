<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class DynamicCrudController extends Controller
{
    public function index($model)
    
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Modelo no encontrado.'], 404);
        }

        $data = $modelClass::all();
        return response()->json($data);
    }

    public function store(Request $request, $model)
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Modelo no encontrado.'], 404);
        }

        $item = $modelClass::create($request->all());

        return response()->json($item, 201);
    }

    public function show($model, $id)
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }


        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Modelo no encontrado.'], 404);
        }

        $item = $modelClass::find($id);

        if (!$item) {
            return response()->json(['error' => 'Registro no encontrado.'], 404);
        }

        return response()->json($item);
    }

    public function update(Request $request, $model, $id)
{
    if (!Auth::check()) {
        return response()->json(['message' => 'No autorizado'], 401);
    }

    $modelClass = 'App\\Models\\' . ucfirst($model);

    if (!class_exists($modelClass)) {
        return response()->json(['error' => 'Modelo no encontrado.'], 404);
    }

    $item = $modelClass::find($id);

    if (!$item) {
        return response()->json(['error' => 'Registro no encontrado.'], 404);
    }

    $item->update($request->all());

    return response()->json($item);
}


    public function destroy($model, $id)
    {

        if (!Auth::check()) {
            return response()->json(['message' => 'No autorizado'], 401);
        }

        $modelClass = 'App\\Models\\' . ucfirst($model);

        if (!class_exists($modelClass)) {
            return response()->json(['error' => 'Modelo no encontrado.'], 404);
        }

        $item = $modelClass::find($id);

        if (!$item) {
            return response()->json(['error' => 'Registro no encontrado.'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Registro eliminado con éxito.']);
    }
}
