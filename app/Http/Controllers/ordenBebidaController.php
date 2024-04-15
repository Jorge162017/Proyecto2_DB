<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Ordenes_Bebidas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ordenBebidaController extends Controller
{
    public function index(\App\Models\Ordenes_Bebidas $order)
    {
        return $order->paginate(2);
    }

    public function __construct(\App\Models\Ordenes_Bebidas $order){
        $this->order = $order;
    }


    public function show($id){

        $result = DB::table('cuenta')
        ->select('cuentaid')
        ->where('mesaid', '=', $id)
        ->where('estado','=', true)
        ->get();


        $order = $this->order
        ->join('bebidas', 'bebidas.bebidaid', '=', 'ordenes_bebidas.bebidaid')
        ->where('cuentaid','=', $result[0]->cuentaid)->get();
        if (!$order) {
            return response()->json(['error' => 'order not found'], 404);
        }
        return response()->json(['order' => $order]);
    }



    public function getPending(){



        $order = $this->order
        ->join('bebidas', 'bebidas.bebidaid', '=', 'ordenes_bebidas.bebidaid')
        ->join('cuenta', 'cuenta.cuentaid', '=', 'ordenes_bebidas.cuentaid')
        ->where('status','=', false)
        ->get();
        if (!$order) {
            return response()->json(['error' => 'order not found'], 404);
        }
        return response()->json(['drink' => $order]);
    }


    public function getDone(){



        $order = $this->order
        ->join('bebidas', 'bebidas.bebidaid', '=', 'ordenes_bebidas.bebidaid')
        ->join('cuenta', 'cuenta.cuentaid', '=', 'ordenes_bebidas.cuentaid')
        ->where('status','=', true)
        ->get();
        if (!$order) {
            return response()->json(['error' => 'order not found'], 404);
        }
        return response()->json(['drink' => $order]);
    }


    public function saveBebida(Request $request){
        $validator = Validator::make($request->all(), [
            'mesaid' => 'required|integer',
            'bebidaid' => 'required|integer',
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



        $order = new Ordenes_Bebidas();
        $order->cuentaid = $result[0]->cuentaid;
        $order->bebidaid = $request->input('bebidaid');
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

        $data = $this->order->where('ordenes_bebidas.orden_bebida_id','=', $id)->update($updateData);

        

        return response()->json(['drink' => $data, 'message' => 'dish done successfully']);
    }


    public function checkPending(Request $request, $id){
        
       
        // Actualizar el modelo usando el método update([])
        $updateData = [
            'status' => false,
        ];

        $data = $this->order->where('ordenes_bebidas.orden_bebida_id','=', $id)->update($updateData);

        

        return response()->json(['drink' => $data, 'message' => 'dish done successfully']);
    }


}
