<?php namespace Portal\Scripts\Repositories\Report;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Portal\Scripts\Contracts\ReportRepository;
use Portal\Scripts\Models\OldSurveyAnswerLog;

class OldEloquentReportRepository implements ReportRepository {

    public function countCompletedScripts($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        // Select all the distinct Lead IDs from the answer log
        $query = OldSurveyAnswerLog::select(DB::raw("count(DISTINCT lead_id) as total"))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->first();

        // Return the count as an integer
        return (int)$query->total;
    }

    public function countCompletedQuestions($questionId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        // TODO: Implement countCompletedQuestions() method.
    }

    public function getAllScriptResults($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        // Select all results from the answer log ready for transforming
        $query = OldSurveyAnswerLog::select("*")
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->get();

        // Return all of the results as an Eloquent Collection
        return $query;
    }

    public function getByQuestionResults(array $questionAndAnswers = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        // TODO: Implement getByQuestionResults() method.
    }

    /**
     * @param integer        $agentId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function getSurveyCountByAgentId($agentId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        $query = OldSurveyAnswerLog::select(DB::raw("DATE(created_at) as 'Date', count(DISTINCT lead_id) as 'Total'"))
            ->where('agent_id', $agentId)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get();

        dd($query);

        return (int)$query;
    }
}