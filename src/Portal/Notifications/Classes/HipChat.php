<?php namespace Portal\Notifications\Classes;

use HipChat\HipChat as HipChatApi;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Queue;
use MySecurePortal\OldPortal\Domain\Users\Models\User;
use Portal\Notifications\Contracts\Notification;

class HipChat implements Notification {
    use DispatchesCommands;

    protected $adminChat = null;
    protected $notifyChat = null;

    public static function sendMessage($message, array $settings = [], User $user = null)
    {
        $thisClass = new self;
        $thisClass->send($message, $settings, $user);
    }

    public function send($message, array $settings = [], User $user = null)
    {
        if (is_null($user))
        {
            $this->sendToRoom(
                isset($settings['roomName']) ? $settings['roomName'] : 'Development',
                isset($settings['fromName']) ? $settings['fromName'] : 'MySecurePortal',
                $message,
                isset($settings['color']) ? $settings['color'] : 'red'
            );
        }

    }

    protected function sendToRoom($roomName, $from, $message, $color, $notify = false)
    {
        Queue::push(function($job) use($roomName, $from, $message, $notify, $color) {
            $this->notifyChat->message_room($roomName, $from, $message, $notify, $color);

            $job->delete();
        });
    }


    public function __construct()
    {
        $this->adminChat = new HipChatApi(Config::get('services.hipchat.admin'));
        $this->notifyChat = new HipChatApi(Config::get('services.hipchat.notify'));
    }

}