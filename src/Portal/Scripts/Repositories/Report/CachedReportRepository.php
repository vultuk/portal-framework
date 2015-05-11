<?php namespace Portal\Scripts\Repositories\Report;

use Carbon\Carbon;
use Illuminate\Cache\Repository as Cache;
use Portal\Foundation\DateTime\SetsCacheTimeByDateRange;
use Portal\Scripts\Contracts\ReportRepository;

class CachedReportRepository implements ReportRepository {
    use SetsCacheTimeByDateRange;

    protected $repository = null;
    protected $cache = null;

    function __construct(ReportRepository $repository, Cache $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    /**
     * @param null           $scriptId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function countCompletedScripts($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null, $status = 'COMPLETE')
    {
        return $this->cache->remember(
            "countCompletedScripts-{$scriptId}-{$dateFrom}-{$dateTo}-{$status}",
            $this->getCacheTime($dateFrom, $dateTo),
            function() use ($scriptId, $dateFrom, $dateTo, $status) {
                return $this->repository->countCompletedScripts($scriptId, $dateFrom, $dateTo, $status);
            }
        );
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
    public function getAllScriptResults($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null, $status = 'COMPLETE')
    {
        return $this->cache->remember(
            "getAllScriptResults-{$scriptId}-{$dateFrom}-{$dateTo}-{$status}",
            $this->getCacheTime($dateFrom, $dateTo),
            function() use ($scriptId, $dateFrom, $dateTo, $status) {
                return $this->repository->getAllScriptResults($scriptId, $dateFrom, $dateTo, $status);
            }
        );
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
        return $this->cache->remember(
            "getSurveyCountByAgentId-{$agentId}-{$dateFrom}-{$dateTo}",
            $this->getCacheTime($dateFrom, $dateTo),
            function() use ($agentId, $dateFrom, $dateTo) {
                return $this->repository->getSurveyCountByAgentId($agentId, $dateFrom, $dateTo);
            }
        );
    }

    /**
     * @param null           $scriptId
     * @param \Carbon\Carbon $dateFrom
     * @param \Carbon\Carbon $dateTo
     *
     * @return mixed
     */
    public function countCompletedScriptsByDate($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null, $status = 'COMPLETE')
    {
        return $this->cache->remember(
            "countCompletedScriptsByDate-{$scriptId}-{$dateFrom}-{$dateTo}-{$status}",
            $this->getCacheTime($dateFrom, $dateTo),
            function() use ($scriptId, $dateFrom, $dateTo, $status) {
                return $this->repository->countCompletedScriptsByDate($scriptId, $dateFrom, $dateTo, $status);
            }
        );
    }
}