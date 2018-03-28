<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormTranslation extends Model
{
    protected $table = 'forms_translation';

    protected $fillable = ['form_id', 'lang_id', 'title', 'description', 'code'];

    public function form() {
        return $this->belongsTo(Form::class);
    }
}
