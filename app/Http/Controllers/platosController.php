<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Platos;
use Illuminate\Support\Facades\Validator;

class platosController extends Controller
{
    public function index(\App\Models\Platos $platos)
    {
        return $platos->paginate(2);
    }

    public function __construct(\App\Models\Platos $platos){
        $this->platos = $platos;
    }

    public function destroy($id){
        $platos = $this->platos->find($id);
        if (!$platos) {
            return response()->json(['error' => 'Plato not found'], 404);
        }

        $platos->delete();
        return response()->json(['message' => 'Plato deleted successfully']);
    }


    public function show(){
        $platos = $this->platos->get();
        if (!$platos) {
            return response()->json(['error' => 'Plato not found'], 404);
        }
        return response()->json(['plato'=>$platos,'message' => 'platos encontrados exitosamente']);
    }


    public function save(Request $request){
       

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $platos = new Platos();
        $platos->nombre = $request->input('nombre');
        $platos->descripcion = $request->input('descripcion');
        $platos->precio = $request->input('precio');

        $platos->save();

        return response()->json(['plato'=>$platos,'message' => 'platos guardados exitosamente']);
    }


    public function update(Request $request, $id){
        $platos = Platos::find($id);
        if (!$platos) {
            return response()->json(['error' => 'PLato not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // Actualizar el modelo
        $bebidas->update([
            'nombre' => $request->input('nombre', $platos->nombre), // Utiliza el valor actual como valor predeterminado
            'descripcion' => $request->input('descripcion', $platos->descripcion),
            'precio' => $request->input('precio', $platos->precio)
        ]);

        return response()->json(['platos'=>$platos,'message' => 'platos actualizados exitosamente']);
    }


}

