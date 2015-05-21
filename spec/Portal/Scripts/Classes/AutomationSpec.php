<?php

namespace spec\Portal\Scripts\Classes;

use Carbon\Carbon;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AutomationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        date_default_timezone_set('Europe/London');
        $this->shouldHaveType('Portal\Scripts\Classes\Automation');
    }





    function it_can_default_start_date_to_today()
    {
        $this->setStartDate(null);
        $this->getStartDate()->format('Y-m-d H:i:s')->shouldReturn(Carbon::now()->format('Y-m-d 00:00:00'));
    }

    function it_can_default_end_date_to_today()
    {
        $this->setEndDate(null);
        $this->getEndDate()->format('Y-m-d H:i:s')->shouldReturn(Carbon::now()->format('Y-m-d 23:59:59'));
    }

    function it_can_set_a_start_date()
    {
        $this->setStartDate(Carbon::create(2014,5,12,12,53,12));
        $this->getStartDate()->format('Y-m-d H:i:s')->shouldReturn('2014-05-12 12:53:12');
    }

    function it_can_set_an_end_date()
    {
        $this->setEndDate(Carbon::create(2015,7,15,11,27,36));
        $this->getEndDate()->format('Y-m-d H:i:s')->shouldReturn('2015-07-15 11:27:36');
    }
}
