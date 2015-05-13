<?php namespace Portal\Integrations\Slack\Contracts;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Portal\Integrations\Slack\Classes\SlackNotification;
use Portal\Foundation\Commands\Command;

class SlackCommand extends Command implements SelfHandling, ShouldBeQueued {

    use DispatchesCommands, SerializesModels;

    protected $slack;

    protected $cache;

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

    public static function __callStatic($name, $args)
    {
        $name = "call".ucwords(strtolower($name));
        $thisClass = new Static($args[0]);

        if (!method_exists($thisClass, $name)) {
            return "Sorry, I can't do that! :( ";
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
