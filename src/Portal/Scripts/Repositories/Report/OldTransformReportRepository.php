<?php namespace Portal\Scripts\Repositories\Report;

use Carbon\Carbon;
use Illuminate\Support\Str;
use IlluminateExtensions\Support\Collection;
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
        $resultArray = [];
        $scriptResults = $this->repository->getAllScriptResults($scriptId, $dateFrom, $dateTo);


        foreach ($scriptResults as $result)
        {
            $singleInformation = [];
            if (!isset($resultArray[$result->lead_id]))
            {
                $singleInformation['client.id'] = $result->client->id;
                $singleInformation['client.first_name'] = $result->client->first_name;
                $singleInformation['client.last_name'] = $result->client->last_name;
                $singleInformation['client.address1'] = $result->client->contactdetails[0]->address1;
                $singleInformation['client.address2'] = $result->client->contactdetails[0]->address2;
                $singleInformation['client.address3'] = $result->client->contactdetails[0]->address3;
                $singleInformation['client.town'] = $result->client->contactdetails[0]->town;
                $singleInformation['client.county'] = $result->client->contactdetails[0]->county;
                $singleInformation['client.postal_code'] = $result->client->contactdetails[0]->postal_code;
                $singleInformation['client.telephone'] = $result->client->contactdetails[0]->telephone;
                $singleInformation['client.mobile'] = $result->client->contactdetails[0]->mobile;
                $singleInformation['client.email'] = $result->client->contactdetails[0]->email;
                $singleInformation['optin.date'] = $result->created_at;
            } else {
                $singleInformation = $resultArray[$result->lead_id];
            }


            if (isset($singleInformation[Str::slug($result->question->name)]))
            {
                $currentAnswers = $singleInformation[Str::slug($result->question->name)];

                if (is_array($currentAnswers))
                {
                    array_push($currentAnswers, $result->question_response_value);
                } else {
                    $currentAnswers = [
                        $currentAnswers,
                        $result->question_response_value,
                    ];
                }
            } else {
                $currentAnswers = $result->question_response_value;
            }


            $singleInformation[Str::slug($result->question->name)] = $currentAnswers;

            $resultArray[$result->lead_id] = $singleInformation;
        }

        $returnCollection = new Collection($resultArray);

        return $returnCollection;
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
