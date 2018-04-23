<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProductCategoryTranslation extends Model
{
    protected $table = 'product_categories_translation';

    protected $fillable = ['lang_id', 'name', 'url'];

    public function menu() {

        return $this->belongsTo(ProductCategory::class);
    }
}
