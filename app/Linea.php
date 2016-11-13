<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    protected $table = 'lineas';
    
    public function plantilla()
    {
    	return 	$this->belongsTo('App\PlantillaZona','plantillazona_id');
    }

}
