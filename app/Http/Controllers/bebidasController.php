<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Bebidas;
use Illuminate\Support\Facades\Validator;

class bebidasController extends Controller
{
    public function index(\App\Models\Bebidas $bebidas)
    {
        return $bebidas->paginate(2);
    }

    public function __construct(\App\Models\Bebidas $bebidas){
        $this->bebidas = $bebidas;
    }

    public function destroy($id){
        $bebidas = $this->bebidas->find($id);
        if (!$bebidas) {
            return response()->json(['error' => 'Bebida not found'], 404);
        }

        $bebidas->delete();
        return response()->json(['message' => 'Bebida deleted successfully']);
    }


    public function show(){
        $bebidas = $this->bebidas->get();
        if (!$bebidas) {
            return response()->json(['error' => 'Bebida not found'], 404);
        }
        return response()->json(['bebida'=>$bebidas,'message' => 'bebida encontrada exitosamente']);
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

        $bebidas = new Bebidas();
        $bebidas->nombre = $request->input('nombre');
        $bebidas->descripcion = $request->input('descripcion');
        $bebidas->precio = $request->input('precio');

        $bebidas->save();

        return response()->json(['bebidas'=>$bebidas,'message' => 'bebidas guardadas exitosamente']);
    }


    public function update(Request $request, $id){
        $bebidas = Bebidas::find($id);
        if (!$bebidas) {
            return response()->json(['error' => 'Bebida not found'], 404);
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
            'nombre' => $request->input('nombre', $bebidas->nombre), // Utiliza el valor actual como valor predeterminado
            'descripcion' => $request->input('descripcion', $bebidas->descripcion),
            'precio' => $request->input('precio', $bebidas->precio)
        ]);

        return response()->json(['bebidas'=>$bebidas,'message' => 'bebidas actualizados exitosamente']);
    }


}
