<?php namespace Portal\Slack\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Http\Request;
use IlluminateExtensions\Routing\Controller;

class SlackController extends Controller
{
    use DispatchesCommands;

    protected $token = null;
    protected $channelName = null;
    protected $username = null;
    protected $command = null;
    protected $action = null;
    protected $text = null;

    public function __construct(Request $request)
    {
        parent::__construct();

        $this->token       = $request->input('token');
        $this->channelName = $request->input('channel_name');
        $this->username    = $request->input('user_name');
        $this->command     = str_replace('/', '', $request->input('command'));

        $text = explode(' ', $request->input('text'));

        $this->action = isset($text[0]) ? $text[0] : null;
        unset($text[0]);
        $this->text        = implode(' ', $text);
    }

    public function slashCommand()
    {
        $slackHandler = "\\Portal\\Slack\\Commands\\Slack" . ucwords($this->command);
        $slackCommand = $this->action;

        return $slackHandler::$slackCommand([
            'token' => $this->token,
            'channelName' => $this->channelName,
            'username' => $this->username,
            'command' => $this->command,
            'action' => $this->action,
            'text' => $this->text,
        ]);
    }

}
