<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    public $timestamps = false;

    static public function select(){
        $values = array();
        foreach ( Concept::all()->sortBy('name') as $elem) {
            $values[$elem->id]=$elem->name;
        }
        return $values;
    }
    static public function name($id){
        return Concept::find($id)->name;
    }
}
