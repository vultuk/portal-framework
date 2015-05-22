<?php namespace Portal\Scripts\Classes;

use Carbon\Carbon;
use IlluminateExtensions\Support\Collection;
use Portal\Foundation\DateTime\SetsStartAndEndDate;
use Portal\Scripts\Models\Orders\ScriptResponseOrder;

class Automation extends Collection
{
    use SetsStartAndEndDate;

    private $answerLog;

    public function __construct(ScriptResponseOrder $answerLog, Carbon $startDate = null, Carbon $endDate = null)
    {
        $this->answerLog = $answerLog;
    }


    private function filterSurveyResults()
    {
        return [];
    }

    private function collectRequiredQuestions()
    {
        return [];
    }

    private function transformQuestionHeadings()
    {
        return [];
    }

    private function deliverResults()
    {
        return [];
    }


    private function checkRemainingSupply()
    {
        return 100;
    }

}
