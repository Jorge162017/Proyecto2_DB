<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Areas;
use Illuminate\Support\Facades\Validator;

class areaController extends Controller
{
    public function index(\App\Models\Areas $area)
    {
        return $area->paginate(2);
    }

    public function __construct(\App\Models\Areas $area){
        $this->area = $area;
    }

    public function destroy($id){
        $area = $this->area->find($id);
        if (!$area) {
            return response()->json(['error' => 'Area not found'], 404);
        }

        $area->delete();
        return response()->json(['message' => 'Area deleted successfully']);
    }


    public function show(){
        $area = $this->area->get();
        if (!$area) {
            return response()->json(['error' => 'Area not found'], 404);
        }
        return response()->json(['area'=>$area,'message' => 'areas encontradas exitosamente']);
    }


    public function save(Request $request){
       

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'permisoFumar' => 'required|boolean',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $area = new Areas();
        $area->nombre = $request->input('nombre');
        $area->permisoFumar = $request->input('permisoFumar');

        $area->save();

        return response()->json(['area'=>$area,'message' => 'areas guardada exitosamente']);
    }


    public function update(Request $request, $id){
        $area = Areas::find($id);
        if (!$area) {
            return response()->json(['error' => 'Area not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'permisoFumar' => 'required|boolean',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // Actualizar el modelo
        $area->update([
            'nombre' => $request->input('nombre', $area->nombre), // Utiliza el valor actual como valor predeterminado
            'permisoFumar' => $request->input('permisoFumar', $area->permisoFumar)
        ]);

        return response()->json(['area'=>$area,'message' => 'areas actualizada exitosamente']);
    }


}
