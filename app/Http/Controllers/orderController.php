<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Ordenes;
use Illuminate\Support\Facades\Validator;

class orderController extends Controller
{
    public function index(\App\Models\Ordenes $order)
    {
        return $order->paginate(2);
    }

    public function __construct(\App\Models\Ordenes $order){
        $this->order = $order;
    }
}
