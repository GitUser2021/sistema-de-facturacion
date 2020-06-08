<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'Codigo';
    protected $keyType = 'bigint';
}
