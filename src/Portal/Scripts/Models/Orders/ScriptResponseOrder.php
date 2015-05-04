<?php namespace Portal\Scripts\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class ScriptResponseOrder extends Model {
    use RecordsActivity;

    protected $connection = "portal/framework";

    protected $table = "order_script_responses";

    protected $fillable = [
        'date_format',
        'questions',
        'transformer',
        'filter',
        'email_addresses',
        'send_method',
        'send_address',
        'purchased',
        'supplied',
    ];

    public function details()
    {
        return $this->morphOne('\Portal\Orders\Models\Order', 'details');
    }

}
