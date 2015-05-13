<?php namespace Portal\Integrations\Slack\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Http\Request;
use IlluminateExtensions\Routing\Controller;

class SlackController extends Controller
{

    use DispatchesCommands;

    protected $token = null;
    protected $channelName = null;
    protected $channelId = null;
    protected $userId = null;
    protected $username = null;
    protected $command = null;
    protected $action = null;
    protected $text = null;

    public function __construct(Request $request)
    {
        parent::__construct();

        $this->token       = $request->input('token');
        $this->channelName = $request->input('channel_name');
        $this->channelId   = $request->input('channel_id');
        $this->username    = $request->input('user_name');
        $this->userId      = $request->input('user_id');
        $this->command     = str_replace('/', '', $request->input('command'));

        $text = explode(' ', trim($request->input('text')));

        $this->action = strlen($text[0]) > 0 ? $text[0] : null;
        unset($text[0]);
        $this->text = implode(' ', $text);
    }

    public function slashCommand()
    {
        $slackHandler = "\\Portal\\Integrations\\Slack\\Commands\\Slack" . ucwords($this->command);
        $slackCommand = !is_null($this->action) ? $this->action : 'help';

        return $slackHandler::$slackCommand(
            [
                'token'       => $this->token,
                'channelName' => $this->channelName,
                'channelId'   => $this->channelId,
                'username'    => $this->username,
                'userId'      => $this->userId,
                'command'     => $this->command,
                'action'      => $this->action,
                'text'        => $this->text,
            ]
        );
    }

}
