<?php namespace Portal\Integrations\Slack\SlackCommands;

use Carbon\Carbon;
use Portal\Integrations\Slack\Commands\Choice\AddCollection;
use Portal\Integrations\Slack\Contracts\SlackCommand;

class SlackChoice extends SlackCommand
{

    public function callCollection()
    {
        if (strlen($this->splitText[0]) < 1)
            return "You didn't enter a value!";

        $this->dispatch(
            new AddCollection(Carbon::now(), floatval($this->splitText[0]), $this->username)
        );

        return "Your collection has been registered!";
    }


    public function getHelp()
    {
        return [
            ['collection [value]', 'Registers a collection from a client with a value of [value].']
        ];
    }

}
