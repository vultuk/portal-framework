<?php namespace Portal\Scripts\Contracts;

use Carbon\Carbon;

interface ReportRepository
{

    /**
     * @param null           $scriptId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function countCompletedScripts($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null);

    /**
     * @param null           $questionId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function countCompletedQuestions($questionId = null, Carbon $dateFrom = null, Carbon $dateTo = null);

    /**
     * @param null           $scriptId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function getAllScriptResults($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null);

    /**
     * @param array          $questionAndAnswers
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function getByQuestionResults(array $questionAndAnswers = null, Carbon $dateFrom = null, Carbon $dateTo = null);


    /**
     * @param integer        $agentId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function getSurveyCountByAgentId($agentId = null, Carbon $dateFrom = null, Carbon $dateTo = null);

}