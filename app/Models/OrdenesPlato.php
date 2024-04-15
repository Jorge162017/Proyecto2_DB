<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesPlato extends Model
{
    use HasFactory;


    protected $fillable = [
        'ordenid',
        'cuentaid',
        'platoid',
        'cantidad',
    ];

}
