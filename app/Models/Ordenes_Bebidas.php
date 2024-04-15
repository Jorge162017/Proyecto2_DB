<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Ordenes_Bebidas extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "ordenes_bebidas";
    protected $primaryKey = 'orden_bebida_id';

    protected $fillable = [
        'orden_bebida_id',
        'cuentaid',
        'bebidaid',
        'cantidad',
        'status'
    ];
}
