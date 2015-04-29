<?php namespace Portal\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class Product extends Model {

    protected $connection = "portal/framework";

    protected $table = "products";

    protected $fillable = [];


    public function category()
    {
        return $this->belongsTo('Portal\Products\Models\ProductCategory');
    }

}