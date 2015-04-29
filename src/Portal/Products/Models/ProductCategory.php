<?php namespace Portal\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class ProductCategory extends Model {

    protected $connection = "portal/framework";

    protected $table = "product_categories";

    protected $fillable = [
        'name',
        'description',
    ];

    public function products()
    {
        return $this->hasMany('Portal\Products\Models\Product');
    }

}