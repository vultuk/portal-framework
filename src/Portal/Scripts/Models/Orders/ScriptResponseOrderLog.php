<?php
namespace Portal\Scripts\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class ScriptResponseOrderLog extends Model {

    protected $connection = "portal/framework";

    protected $table = "order_script_response_log";

    protected $fillable = [
        'client_id',
    ];

    public function order()
    {
        return $this->belongsTo('\Portal\Scripts\Models\Orders\ScriptResponseOrder');
    }
}
