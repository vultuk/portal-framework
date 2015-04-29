<?php namespace Portal\Scripts\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class ScriptResponseOrder extends Model {
    use RecordsActivity;

    protected $connection = "portal/framework";

    protected $table = "order_script_responses";

    protected $fillable = [ ];

    public function order()
    {
        return $this->morphTo();
    }

}