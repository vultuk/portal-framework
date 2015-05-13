<?php namespace Portal\Integrations\Slack\Commands;

use Carbon\Carbon;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Queue;
use IlluminateExtensions\Support\Collection;
use MySecurePortal\OldPortal\Classes\Dashboard\Reports\Surveys;
use MySecurePortal\OldPortal\Models\Vicidial\AgentGroups;
use Portal\Foundation\Commands\Command;
use Portal\Integrations\Slack\Classes\SlackNotification;

class SlackSurvey extends Command implements SelfHandling, ShouldBeQueued
{

    use SerializesModels, DispatchesCommands;

    protected $slack;

    protected $token;
    protected $channelName;
    protected $channelId;
    protected $username;
    protected $userId;
    protected $command;
    protected $action;
    protected $text;


    public function callDebug()
    {
        return implode(', ', [
            $this->token,
            $this->channelName,
            $this->channelId,
            $this->username,
            $this->userId,
            $this->command,
            $this->action,
            $this->text,
        ]);
    }


    public function callAgents()
    {
        $details = explode(' ', $this->text);

        $count = isset($details[0]) ? $details[0] : 5;
        $group = isset($details[1]) ? $details[1] : 'LEADGEN';

        $name = ucwords(strtolower($group));

        Queue::push(function($job) use($group, $count, $name) {
            $results = $this->agentList($group, $count);
            $this->sendSingleCampaign($results, $name);

            $job->delete();
        });

        return "Top {$count} {$name} agents coming up!";
    }

    private function sendSingleCampaign(Collection $results, $usergroup)
    {
        if (count($results) > 0)
        {
            $fieldHolder = [
                SlackNotification::attachmentField([
                    'title' => 'Agent Name',
                    'short' => true,
                ]),
                SlackNotification::attachmentField([
                    'title' => 'Results',
                    'short' => true,
                ]),
            ];

            foreach ($results as $single)
            {
                $fieldHolder[] = SlackNotification::attachmentField([
                    'value' => $single['name'],
                    'short' => true,
                ]);

                $fieldHolder[] = SlackNotification::attachmentField([
                    'value' => $single['full'] . ' full, ' . $single['part'] . ' partials.',
                    'short' => true,
                ]);
            }

            $sendResults = SlackNotification::attachment([
                'fields' => $fieldHolder,
                'color' => 'good',
                'mrkdwn_in' => ['text'],
            ]);

            Queue::push(function($job) use($sendResults, $results, $usergroup) {
                $this->slack
                    ->to($this->channelId)
                    ->from('Survey Team')
                    ->withIcon('http://www.yarramsc.vic.edu.au/wp-content/uploads/2012/07/Survey-Icon.png')
                    ->setAttachments([$sendResults])
                    ->send("*Top " . count($results) ." {$usergroup} agents!*");

                $job->delete();
            });
        }
    }

    private function agentList($userGroup, $limit = null, Carbon $startDate = null, Carbon $endDate = null)
    {
        $startDate = is_null($startDate) ? Carbon::now()->hour(0)->minute(0)->second(0) : $startDate;
        $endDate = is_null($endDate) ? Carbon::now() : $endDate;

        $group = AgentGroups::with('agents', 'agents.scriptlog')->find($userGroup);

        $results = [];

        foreach ($group->agents as $agent)
        {
            $fullSurveyCount = $agent->scriptlog()->whereBetween('completed_at', [$startDate, $endDate])->where('status', 'COMPLETE')->count();
            $partialSurveyCount = $agent->scriptlog()->whereBetween('completed_at', [$startDate, $endDate])->where('status', 'PARTIAL')->count();

            $results[] = [
                'name' => $agent->full_name,
                'full' => $fullSurveyCount,
                'part' => $partialSurveyCount,
            ];

        }


        return (new Collection($results))->sortByDesc(function($r) {
            return $r['full'];
        })->limit($limit);
    }




    public function callDisplay()
    {
        $this->sendSurveyResults($this->userId);
        return 'Survey results coming up!';
    }

    public function callAnnounce()
    {
        $this->sendSurveyResults($this->channelId);
        return 'Survey results coming up!';
    }


    private function sendSurveyResults($to)
    {
        $fullResults = SlackNotification::attachment([
            'fallback' => str_replace(['<b>', '</b>'], ['', ''], Surveys::surveys(Carbon::today(), Carbon::now())['currentText']),
            'text' => str_replace(['<b>', '</b>'], ['*', '*'], Surveys::surveys(Carbon::today(), Carbon::now())['currentText']),
            'color' => 'good',
            'mrkdwn_in' => ['text'],
        ]);

        $partialResults = SlackNotification::attachment([
            'fallback' => str_replace(['<b>', '</b>'], ['', ''], Surveys::surveysTele(Carbon::today(), Carbon::now())['currentText']),
            'text' => str_replace(['<b>', '</b>'], ['*', '*'], Surveys::surveysTele(Carbon::today(), Carbon::now())['currentText']),
            'color' => 'warning',
            'mrkdwn_in' => ['text'],
        ]);

        Queue::push(function($job) use($to, $fullResults, $partialResults) {
            $this->slack
                ->to($to)
                ->from('Survey Team')
                ->withIcon('http://www.yarramsc.vic.edu.au/wp-content/uploads/2012/07/Survey-Icon.png')
                ->setAttachments([$fullResults, $partialResults])
                ->send('');

            $job->delete();
        });



    }


    public static function __callStatic($name, $args)
    {
        $name = "call".ucwords(strtolower($name));
        $thisClass = new Static($args[0]);

        if (!method_exists($thisClass, $name)) {
            return "Sorry, I can't do that! :( ". $name;
        }

        return $thisClass->$name();
    }

    public function __construct(array $settings)
    {
        $this->slack = SlackNotification::create();

        $this->token       = $settings['token'];
        $this->channelName = $settings['channelName'];
        $this->channelId = $settings['channelId'];
        $this->username    = $settings['username'];
        $this->userId    = $settings['userId'];
        $this->command     = $settings['command'];
        $this->action      = $settings['action'];
        $this->text        = $settings['text'];
    }

}
