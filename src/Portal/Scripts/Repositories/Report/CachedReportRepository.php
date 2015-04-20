<?php namespace Portal\Scripts\Repositories\Report;

use Carbon\Carbon;
use Illuminate\Cache\Repository as Cache;
use Portal\Scripts\Contracts\ReportRepository;

class CachedReportRepository implements ReportRepository {

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
    public function countCompletedScripts($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        return $this->cache->remember(
            "countCompletedScripts-{$scriptId}-{$dateFrom}-{$dateTo}",
            2,
            function() use ($scriptId, $dateFrom, $dateTo) {
                return $this->repository->countCompletedScripts($scriptId, $dateFrom, $dateTo);
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
    public function getAllScriptResults($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null)
    {
        return $this->cache->remember(
            "getAllScriptResults-{$scriptId}-{$dateFrom}-{$dateTo}",
            2,
            function() use ($scriptId, $dateFrom, $dateTo) {
                return $this->repository->getAllScriptResults($scriptId, $dateFrom, $dateTo);
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
}