<?php namespace Portal\Scripts\Models;

use Illuminate\Database\Eloquent\Model;

class OldSurveyAnswerLog extends Model
{

    protected $table = 'survey_answer_log';


    public function client()
    {
        return $this->hasOne('\MySecurePortal\OldPortal\Domain\Crm\Models\Clients', 'id', 'lead_id');
    }

    public function question()
    {
        return $this->hasOne('\MySecurePortal\OldPortal\Models\Scripts\Question', 'id', 'question_id');
    }

}