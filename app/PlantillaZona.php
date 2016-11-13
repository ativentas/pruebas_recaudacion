<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlantillaZona extends Model
{
    protected $table = 'plantillazonas';
    
    public function lineas()
    {
    	return 	$this->hasMany('App\Linea','plantillazona_id');
    }
	
	public function getYearSemanaAttribute($value)
	{
	    return $this->year . $this->semana;
	}
}

