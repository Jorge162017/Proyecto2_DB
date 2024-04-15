<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\OrdenesPlato;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class ordenPlatoController extends Controller
{
    public function index(\App\Models\OrdenesPlato $order)
    {
        return $order->paginate(2);
    }

    public function __construct(\App\Models\OrdenesPlato $order){
        $this->order = $order;
    }


    public function getPending(){



        $order = $this->order
        ->join('platos', 'platos.platoid', '=', 'ordenes_platos.platoid')
        ->join('cuenta', 'cuenta.cuentaid', '=', 'ordenes_platos.cuentaid')
        ->where('status','=', false)
        ->get();
        if (!$order) {
            return response()->json(['error' => 'order not found'], 404);
        }
        return response()->json(['dish' => $order]);
    }


    public function getDone(){



        $order = $this->order
        ->join('platos', 'platos.platoid', '=', 'ordenes_platos.platoid')
        ->join('cuenta', 'cuenta.cuentaid', '=', 'ordenes_platos.cuentaid')
        ->where('status','=', true)
        ->get();
        if (!$order) {
            return response()->json(['error' => 'order not found'], 404);
        }
        return response()->json(['dish' => $order]);
    }


    public function show($id){

        $result = DB::table('cuenta')
        ->select('cuentaid')
        ->where('mesaid', '=', $id)
        ->where('estado','=', true)
        ->get();


        $order = $this->order
        ->join('platos', 'platos.platoid', '=', 'ordenes_platos.platoid')
        ->where('cuentaid','=', $result[0]->cuentaid)
        ->get();
        if (!$order) {
            return response()->json(['error' => 'order not found'], 404);
        }
        return response()->json(['order' => $order]);
    }



    public function savePlato(Request $request){
        $validator = Validator::make($request->all(), [
            'mesaid' => 'required|integer',
            'platoid' => 'required|integer',
            'cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        

        $result = DB::table('cuenta')
        ->select('cuentaid')
        ->where('mesaid', '=', $request->input('mesaid'))
        ->where('estado','=', true)
        ->get();



        $order = new OrdenesPlato();
        $order->cuentaid = $result[0]->cuentaid;
        $order->platoid = $request->input('platoid');
        $order->cantidad = $request->input('cantidad');
        $order->status = false;

        $order->save();

        return response()->json(['order' => $order, 'message' => 'order saved successfully']);
    }



    public function checkDone(Request $request, $id){
        
       
        // Actualizar el modelo usando el método update([])
        $updateData = [
            'status' => true,
        ];

        $data = $this->order->where('ordenes_platos.ordenid','=', $id)->update($updateData);

        

        return response()->json(['dish' => $data, 'message' => 'dish done successfully']);
    }


    public function checkPending(Request $request, $id){
        
       
        // Actualizar el modelo usando el método update([])
        $updateData = [
            'status' => false,
        ];

        $data = $this->order->where('ordenes_platos.ordenid','=', $id)->update($updateData);

        

        return response()->json(['dish' => $data, 'message' => 'dish done successfully']);
    }

}
