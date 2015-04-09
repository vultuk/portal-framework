<?php namespace Portal\Http\Controllers\Ticket;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TicketController extends BaseController {

    use DispatchesCommands, ValidatesRequests;

    public function getIndex()
    {
        dd('Index Page');
    }

}