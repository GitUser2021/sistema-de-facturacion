<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'id_factura';

    public function rel_Cliente(){
        return $this->belongsTo('App\Cliente','id_cliente','id_cliente');
    }
    public function rel_Vendedor(){
        return $this->belongsTo('App\Vendedor','id_vendedor','id_vendedor');
    }
}

