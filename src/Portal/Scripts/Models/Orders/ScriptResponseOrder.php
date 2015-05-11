<?php namespace Portal\Scripts\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class ScriptResponseOrder extends Model {
    use RecordsActivity;

    protected $connection = "portal/framework";

    protected $table = "order_script_responses";

    protected $fillable = [
        'script_id',
        'date_format',
        'questions',
        'transformer',
        'filter',
        'send_method',
        'send_settings',
        'purchased',
        'supplied',
    ];

    public function details()
    {
        return $this->morphOne('\Portal\Orders\Models\Order', 'details');
    }

    public function log()
    {
        return $this->hasMany('\Portal\Scripts\Models\Orders\ScriptResponseOrderLog', 'order_script_response_id');
    }

}
