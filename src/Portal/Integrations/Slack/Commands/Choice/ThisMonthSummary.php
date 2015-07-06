<?php
    namespace Portal\Integrations\Slack\Commands\Choice;

    use Carbon\Carbon;
    use Illuminate\Contracts\Bus\SelfHandling;
    use Illuminate\Contracts\Queue\ShouldBeQueued;
    use Illuminate\Queue\SerializesModels;
    use Portal\Foundation\Commands\Command;
    use Portal\Integrations\Slack\Classes\SlackNotification;
    use Portal\Integrations\Slack\Models\Choice\DailyResults;

    class ThisMonthSummary extends Command implements SelfHandling, ShouldBeQueued
    {

        use SerializesModels;

        protected $slack;
        protected $thisMonth;
        protected $user;

        public function handle()
        {
            $collected = $collectedValue = $wins = $winsValue = $feesDue = 0;

            $this->thisMonth->each(
                function ($r) use (&$collected, &$collectedValue, &$wins, &$winsValue, &$feesDue) {
                    $collected += $r->collected;
                    $collectedValue += $r->collected_value;
                    $wins += $r->wins;
                    $winsValue += $r->win_value;
                    $feesDue += $r->fees_due;
                }
            );

            $collectedValue = number_format($collectedValue, 2);
            $winsValue = number_format($winsValue, 2);
            $feesDue = number_format($feesDue, 2);

            $this->slack     = SlackNotification::create();
            $this->postMessage(
                "*Total values for Choice Claims this month are...*",
                "*Total wins:* {$wins} with a value of £{$winsValue} and a total of £{$feesDue} in fees due\n*Total Collected:* {$collected} with a value of £{$collectedValue}"
            );
        }

        protected function postMessage($message, $totalMessage)
        {

            $this->slack->to($this->user)
                ->from('Choice Claims')
                ->withIcon('https://s3-eu-west-1.amazonaws.com/choice-claims/images/choice_icon.png')
                ->setAttachments(
                    [
                        SlackNotification::attachment(
                            [
                                'text' => $totalMessage,
                                'color' => 'good',
                                'mrkdwn_in' => ['title', 'text'],
                            ]
                        )
                    ]
                )
                ->send($message);

        }

        public function __construct($user)
        {
            $this->thisMonth = DailyResults::whereBetween(
                'today',
                [Carbon::now()->day(1)->format('Y-m-d'), Carbon::now()->addDay()->format('Y-m-d')]
            )->get();
            $this->user = $user;
        }
    }
