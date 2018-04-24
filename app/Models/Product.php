<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function translations()
    {
        return $this->hasMany(ProductTranslation::class);
    }

    public function translation()
    {
        $lang = Lang::where('lang', session('applocale'))->first()->id ?? Lang::first()->id;

        return $this->hasMany(ProductTranslation::class)->where('lang_id', $lang);
    }

}
