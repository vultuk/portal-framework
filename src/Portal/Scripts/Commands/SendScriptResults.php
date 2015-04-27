<?php namespace Portal\Scripts\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Portal\Foundation\Commands\Command;

class SendScriptResults extends Command implements SelfHandling {

    public function handle()
    {
        dd('Command Activated');
    }

}