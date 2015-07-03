<?php namespace Portal\Scripts\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use MySecurePortal\OldPortal\Domain\Companies\Models\Company;
use MySecurePortal\OldPortal\Models\Scripts\Question;
use MySecurePortal\OldPortal\Models\Scripts\Script;
use Illuminate\Cache\Repository as Cache;


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

    public function answer()
    {
        return $this->hasOne('\MySecurePortal\OldPortal\Models\Scripts\Option', 'id', 'question_response_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public static function getAnswerCountFromSurvey($surveyId, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        $cache = App::make('cache.store');

        return $cache->remember(
            "surveyPies-{$surveyId}-{$dateFrom}-{$dateTo}",
            5,
            function() use($surveyId, $dateFrom, $dateTo) {
                $responses = Script::with('sections', 'sections.questions', 'sections.questions.options')
                                   ->find($surveyId);

                $details = [];
                foreach ($responses->sections as $section)
                {
                    if (count($section->questions) > 0)
                    {
                        $question = $section->questions[0];

                        $details[$question->id] = [
                            'question' => $question->name,
                            'responses' => OldSurveyAnswerLog::getAnswerCountFromQuestion($question, $dateFrom, $dateTo),
                        ];
                    }
                }

                return $details;
            }
        );

    }

    public static function getAnswerCountFromQuestion(Question $question, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        $details = [];
        foreach ($question->options as $option)
        {
            $details[$option->id] = [
                'response' => $option->value,
                'count' => $option->responses()->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            ];
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
