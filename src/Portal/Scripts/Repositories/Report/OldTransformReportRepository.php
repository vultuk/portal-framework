<?php namespace Portal\Scripts\Repositories\Report;

use Carbon\Carbon;
use Portal\Scripts\Contracts\ReportRepository;

class OldTransformReportRepository implements ReportRepository {

    protected $repository = null;

    function __construct(ReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param null           $scriptId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function countCompletedScripts($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        return $this->repository->countCompletedScripts($scriptId, $dateFrom, $dateTo);
    }

    /**
     * @param null           $questionId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function countCompletedQuestions($questionId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        // TODO: Implement countCompletedQuestions() method.
    }

    /**
     * @param null           $scriptId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function getAllScriptResults($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        return $this->repository->getAllScriptResults($scriptId, $dateFrom, $dateTo);
    }

    /**
     * @param array          $questionAndAnswers
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function getByQuestionResults(
        array $questionAndAnswers = null,
        Carbon $dateFrom = null,
        Carbon $dateTo = null
    ) {
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
        $results = $this->repository->getSurveyCountByAgentId($agentId, $dateFrom, $dateTo);

        $returnArray = [];

        array_map(function($c) use(&$returnArray) {
            $returnArray[$c['Date']] = $c['Total'];
        }, is_null($results) ? [] : $results->toArray());

        return $returnArray;
    }
}