<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParameterTranslation extends Model
{
    protected $fillable = ['parameter_id', 'lang_id', 'title'];

    protected $table = 'parameter_translations';

    public function parameter()
    {
    	return $this->belongsTo(Parameter::class);
    }
}
