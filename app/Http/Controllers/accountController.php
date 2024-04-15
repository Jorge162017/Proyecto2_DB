<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Cuenta;
use Illuminate\Support\Facades\Validator;

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
        $order = $this->account
        ->join('mesas', 'cuenta.mesaid', '=', 'mesas.mesaid')->get();
        if (!$account) {
            return response()->json(['error' => 'account not found'], 404);
        }
        return response()->json(['account' => $account]);
    }


    public function openAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'mesaid' => 'required|integer',
            'fecha' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $account = new Cuenta();
        $account->mesaid = $request->input('mesaid');
        $account->fecha = $request->input('fecha');
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
        
        $account = Cuenta::find($id);
        if (!$account) {
            return response()->json(['error' => 'account not found'], 404);
        }

       
        // Actualizar el modelo usando el método update([])
        $updateData = [
            'estado' => false,
        ];

        $account->update($updateData);

        return response()->json(['account' => $account, 'message' => 'account closed successfully']);
    }

}
