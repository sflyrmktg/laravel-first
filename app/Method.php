<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
	public $timestamps = false;

    static public function select(){
        $values = array();
        foreach ( Method::all()->sortBy('name') as $elem) {
            $values[$elem->id]=$elem->name;
        }
        return $values;
    }
    static public function name($id){
        return Method::find($id)->name;
    }

}
