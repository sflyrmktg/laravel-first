<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public $fillable = ['explanation','made_at','method_id','concept_id','value','isvalid'];
    public $timestamps = false;

	public function concept() {
		return $this->belongsTo('App\Concept','concept_id');
	}

	public function method() {
		return $this->belongsTo('App\Method','method_id');
	}

}
