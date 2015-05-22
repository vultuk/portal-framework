<?php namespace Portal\Scripts\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Maknz\Slack\Client;
use Portal\Foundation\Commands\Command;
use Portal\Scripts\Models\Orders\ScriptResponseOrder;

class CorrectScriptProgress extends Command implements SelfHandling, ShouldBeQueued {
    use SerializesModels;

    protected $orderScriptResponse;
    protected $surveyRepository;

    public function handle()
    {
        if ($this->orderScriptResponse->purchased != 0)
        {
            $average = $this->averageLeadsSent();
            $remainingLeads = $this->orderScriptResponse->purchased - $this->orderScriptResponse->supplied;

            $remainingDays = $remainingLeads / $average;
            $completionPercentage = ($this->orderScriptResponse->supplied / $this->orderScriptResponse->purchased) * 100;

            $this->orderScriptResponse->details->estimated_completion_time = ceil($remainingDays);
            $this->orderScriptResponse->details->completion_percentage = $completionPercentage;

            $this->orderScriptResponse->details->save();

            if (ceil($remainingDays) <= 2 && is_null($this->orderScriptResponse->details->completed_at))
            {
                $companyName = $this->orderScriptResponse->details->link->name;
                $companySlug = $this->orderScriptResponse->details->link->slug;
                $remaining = ceil($remainingDays);

                $client = new Client('https://hooks.slack.com/services/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');

                $client
                    ->to('data-sales')
                    ->from('Data Sales')
                    ->withIcon('http://americanredcross.github.io/Guides/CaerusGeo/img/icon_paper.png')
                    ->attach([
                        'title' => $companyName,
                        'title_link' => 'https://choiceclaims.mysecureportal.net/company/' . $companySlug,
                        'fallback' => $companyName . " has almost reached the total amount of leads they purchased.\nThey only have an estimated " . $remaining . ' day'. ($remaining > 1 ? 's' : '') ." remaining.\nThey receive " . $average . ' leads per day and require ' . $remainingLeads. ' more to complete their quota.',
                        'text' => $companyName . " has almost reached the total amount of leads they purchased.\nThey only have an estimated " . $remaining . ' day'. ($remaining > 1 ? 's' : '') ." remaining.\nThey receive " . $average . ' leads per day and require ' . $remainingLeads. ' more to complete their quota.',
                        'color' => 'danger',

                    ])
                    ->send(null);
            }

        }
    }



    protected function averageLeadsSent()
    {
        $dayQuery = $this->orderScriptResponse->log()->select(DB::raw("DATE(created_at) as date, COUNT(created_at) as total"))->groupBy(DB::raw("DATE(created_at)"))->get();

        $totalDays = $totalLeads = 0;
        $dayQuery->each(function($l) use(&$totalDays, &$totalLeads) {
            $totalDays++;
            $totalLeads += $l->total;
        });

        return $totalLeads / $totalDays;
    }


    function __construct(ScriptResponseOrder $response = null)
    {
        $this->orderScriptResponse = $response;
        $this->surveyRepository = App::make('survey');
    }

}
