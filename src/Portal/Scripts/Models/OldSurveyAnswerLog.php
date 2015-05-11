<?php namespace Portal\Scripts\Models;

use Carbon\Carbon;
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



    public static function getAnswerCountFromSurvey($surveyId, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        $thisClass = new Static();
        list($dateFrom, $dateTo) = $thisClass->setDefaultDates($dateFrom, $dateTo);

        $query = $thisClass
            ->with('questionDetails')
            ->distinct()
            ->select('question_id')
            ->where('script_id', $surveyId)
            ->orderBy('question_id')
            ->get();

        $details = [];
        foreach ($query as $result) {
            $details[$result->question_id] = [
                'question'  => $result->questionDetails->alias,
                'responses' => OldSurveyAnswerLog::getAnswerCountFromQuestion($result->question_id, $dateFrom,
                    $dateTo),
            ];
        }

        return $details;
    }

    public static function getAnswerCountFromQuestion($questionId, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        $thisClass = new Static();
        list($dateFrom, $dateTo) = $thisClass->setDefaultDates($dateFrom, $dateTo);

        $query = $thisClass
            ->with('answerDetails')
            ->select('question_response_id', \DB::raw("COUNT(lead_id) as total"))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->where('question_id', $questionId)
            ->groupBy('question_response_id')
            ->get();

        $details = [];
        foreach ($query as $result) {
            if ($result->question_response_id > 0) {
                $details[$result->question_response_id] = [
                    'count'    => $result->total,
                    'response' => $result->answerDetails->value,
                ];
            }
        }

        return $details;
    }






    private function setDefaultDates(Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        return [
            is_null($dateFrom) ? new Carbon('2013-01-01 00:00:00') : $dateFrom,
            is_null($dateTo) ? new Carbon((new Carbon())->addDay()->format('Y-m-d 00:00:00')) : $dateTo
        ];
    }

}
