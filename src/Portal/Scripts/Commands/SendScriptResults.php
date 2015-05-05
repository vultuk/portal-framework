<?php namespace Portal\Scripts\Commands;

use Aws\CloudFront\Exception\Exception;
use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use MySecurePortal\OrderScriptResponse;
use Portal\Foundation\Commands\Command;
use Portal\Foundation\DateTime\SetsStartAndEndDate;
use Portal\Scripts\Models\Orders\ScriptResponseOrder;

class SendScriptResults extends Command implements SelfHandling {
    use SetsStartAndEndDate;

    protected $orderScriptResponseId = null;


    protected function sendScriptResults(ScriptResponseOrder $response)
    {
        $remainingLeads = $this->checkRemainingSupply($response);

        dd($remainingLeads);

    }

    protected function checkRemainingSupply(ScriptResponseOrder $response)
    {
        if ($response->purchased > 0 && $response->supplied >= $response->purchased)
        {
            throw new Exception('No leads left to be sent - Please create a new order');
        }

        return $response->purchased - $response->supplied;
    }

    public function handle()
    {
        if (is_null($this->orderScriptResponseId))
        {
            $allScriptOrders = ScriptResponseOrder::with('details')->whereHas('details', function($query) {
                $query->whereNull('completed_at');
            })->get();
            foreach ($allScriptOrders as $order)
            {
                $this->sendScriptResults($order);
            }
        } else {
            $this->sendScriptResults($this->orderScriptResponseId);
        }
    }

    function __construct(ScriptResponseOrder $response = null, Carbon $startDate = null, Carbon $endDate = null)
    {
        $this->orderScriptResponseId = $response;
        $this->setStartDate($startDate)->setEndDate($endDate);
    }

}
