<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    public function translations()
    {
        return $this->hasMany(ParameterTranslation::class);
    }

    public function translation()
    {
        $lang = Lang::where('lang', session('applocale'))->first()->id ?? Lang::first()->id;

        return $this->hasMany(ParameterTranslation::class)->where('lang_id', $lang);
    }
}
