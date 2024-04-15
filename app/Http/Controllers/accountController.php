<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Cuenta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class accountController extends Controller
{
    public function index(\App\Models\Cuenta $account)
    {
        return $account->paginate(2);
    }

    public function __construct(\App\Models\Cuenta $account){
        $this->account = $account;
    }


    public function show(){
        $account = $this->account
        ->join('mesas', 'cuenta.mesaid', '=', 'mesas.mesaid')->get();
        if (!$account) {
            return response()->json(['error' => 'account not found'], 404);
        }
        return response()->json(['account' => $account]);
    }

    public function showById($id){
        $account = $this->account
        ->join('mesas', 'cuenta.mesaid', '=', 'mesas.mesaid')
        ->where('cuenta.mesaid','=', $id)->get();
        if (!$account) {
            return response()->json(['error' => 'account not found'], 404);
        }
        return response()->json(['account' => $account]);
    }


    public function openAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'mesaid' => 'required|integer',
            'fecha' => 'required',
            'nombre'=>'required',
            'nit'=>'required',
            'direccion'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $clientData = [
            'nombre' => $request->input("nombre"),
            'nit' => $request->input("nit"),
            'direccion' => $request->input("direccion")
        ];

        $clientid = DB::table('cliente')->insertGetId($clientData,'clienteid');


        $account = new Cuenta();
        $account->mesaid = $request->input('mesaid');
        $account->fecha = $request->input('fecha');
        $account->clienteid = $clientid;
        $account->total = 0;
        $account->estado = true;

        $account->save();

        return response()->json(['account' => $account, 'message' => 'account saved successfully']);
    }


    public function destroy($id){
        $account = $this->account->find($id);
        if (!$account) {
            return response()->json(['error' => 'account not found'], 404);
        }

        $account->delete();
        return response()->json(['message' => 'account deleted successfully']);
    }



    public function closeAccount(Request $request, $id){
        
       
        // Actualizar el modelo usando el método update([])
        $updateData = [
            'estado' => false,
        ];

        $data = $this->account->where('cuenta.mesaid','=', $id)->update($updateData);

        

        return response()->json(['account' => $data, 'message' => 'account closed successfully']);
    }

}
