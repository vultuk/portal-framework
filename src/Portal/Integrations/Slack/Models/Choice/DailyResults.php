<?php namespace Portal\Integrations\Slack\Models\Choice;

use Illuminate\Database\Eloquent\Model;

class DailyResults extends Model
{

    protected $connection = "portal/framework";

    protected $table = "integration_slack_choice";

    protected $fillable = [
        'today',
        'collected',
        'collected_value',
        'wins',
        'win_value',
        'fees_due',
    ];

}
