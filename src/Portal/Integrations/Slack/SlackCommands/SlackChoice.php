<?php namespace Portal\Integrations\Slack\SlackCommands;

use Carbon\Carbon;
use Portal\Integrations\Slack\Commands\Choice\AddCollection;
use Portal\Integrations\Slack\Commands\Choice\AddWin;
use Portal\Integrations\Slack\Commands\Choice\ThisMonthSummary;
use Portal\Integrations\Slack\Contracts\SlackCommand;

class SlackChoice extends SlackCommand
{

    public function callCollection()
    {
        if (strlen($this->splitText[0]) < 1)
            return "You didn't enter a value!";

        $this->dispatch(
            new AddCollection(Carbon::now(), floatval(str_replace('£', '', $this->splitText[0])), $this->username)
        );

        return "Your collection has been registered!";
    }

    public function callWin()
    {
        if (strlen($this->splitText[0]) < 1)
            return "You didn't enter a value!";

        if (!isset($this->splitText[1]) || strlen($this->splitText[1]) < 1)
            $feePercentage = 30;
        else
            $feePercentage = floatval(str_replace('%', '', $this->splitText[1]));

        $this->dispatch(
            new AddWin(Carbon::now(), floatval(str_replace('£', '', $this->splitText[0])), $this->username, $feePercentage)
        );

        return "Your win has been registered!";
    }


    public function callThismonth()
    {
        $this->dispatch(
            new ThisMonthSummary($this->userId)
        );

        return "Getting results for this month.";
    }



    public function getHelp()
    {
        return [
            ['collection [value]', 'Registers a collection from a client with a value of [value].'],
            ['win [value] [fee-percentage]', 'Registers a win for a client with a value of [value], if no [fee-percentage] is given it defaults to 30%.'],
            ['thismonth', 'Shows the total wins and collections for the whole of this month.'],
        ];
    }

}
