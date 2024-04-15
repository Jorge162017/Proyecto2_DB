<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesPlato extends Model
{
    use HasFactory;


    protected $table = "ordenes_platos";
    protected $primaryKey = 'ordenid';

    protected $fillable = [
        'ordenid',
        'cuentaid',
        'platoid',
        'cantidad',
        'status'
    ];

}
