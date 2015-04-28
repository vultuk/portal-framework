<?php namespace Portal\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class Order extends Model {
    use RecordsActivity;

    protected static $recordedEvents = ['created', 'updated', 'deleted'];

    protected $connection = "portal/framework";

    protected $table = "orders";

    protected $fillable = [

    ];


    public function product()
    {
        return $this->belongsTo('Portal\Products\Models\Product');
    }

    public function link()
    {
        return $this->morphTo();
    }

    public function details()
    {
        return $this->morphMany();
    }

}