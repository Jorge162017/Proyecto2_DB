<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Mesas;
use Illuminate\Support\Facades\Validator;


class tableController extends Controller
{
    public function index(\App\Models\Mesas $table)
    {
        return $table->paginate(2);
    }

    public function __construct(\App\Models\Mesas $table){
        $this->table = $table;
    }


    public function show()
    {
        $table = $this->table->get();
        if (!$table) {
            return response()->json(['error' => 'Table not found'], 404);
        }
        return response()->json(['table' => $table]);
    }


    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'AreaId' => 'required|integer',
            'capacidad' => 'required|integer',
            'puedeMoverse' => 'required|boolean',
            'disponible' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $table = new Table();
        $table->AreaId = $request->input('AreaId');
        $table->capacidad = $request->input('capacidad');
        $table->puedeMoverse = $request->input('puedeMoverse');
        $table->disponible = $request->input('disponible');
        $table->save();

        return response()->json(['table' => $table, 'message' => 'Table saved successfully']);
    }


    public function destroy($id){
        $table = $this->table->find($id);
        if (!$table) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $table->delete();
        return response()->json(['message' => 'Table deleted successfully']);
    }



    public function update(Request $request, $id){
        
        $table = Table::find($id);
        if (!$table) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'AreaId' => 'sometimes|required|integer',
            'capacidad' => 'sometimes|required|integer',
            'puedeMoverse' => 'sometimes|required|boolean',
            'disponible' => 'sometimes|required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar el modelo usando el método update([])
        $updateData = [
            'AreaId' => $request->input('AreaId', $table->AreaId),
            'capacidad' => $request->input('capacidad', $table->capacidad),
            'puedeMoverse' => $request->input('puedeMoverse', $table->puedeMoverse),
            'disponible' => $request->input('disponible', $table->disponible),
        ];

        $table->update($updateData);

        return response()->json(['table' => $table, 'message' => 'Table updated successfully']);
    }

}
