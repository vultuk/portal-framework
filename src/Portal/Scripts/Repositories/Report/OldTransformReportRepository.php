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
    public function countCompletedScripts($scriptId = null, Carbon $dateFrom = null, Carbon $dateTo = null, $status = 'COMPLETE')
    {
        return $this->repository->countCompletedScripts($scriptId, $dateFrom, $dateTo, $status);
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
        $resultArray = [];
        $scriptResults = $this->repository->getAllScriptResults($scriptId, $dateFrom, $dateTo, $status);


        foreach ($scriptResults as $result)
        {
            if (!is_null($result->client)) {
                $singleInformation = [];
                if (!isset($resultArray[$result->lead_id])) {

                    $singleInformation['company.id']         = !empty($result->company->id) ? $result->company->id : '';
                    $singleInformation['company.name']       = !empty($result->company->company_name) ? $result->company->company_name : '';

                    $singleInformation['survey.status']      =

                    $singleInformation['client.id']          = !empty($result->client->id) ? $result->client->id : '';
                    $singleInformation['client.id.commsave'] = !empty($result->client->id) ? 'NG' . $result->client->id : '';
                    $singleInformation['client.title']       = !empty(
                        $result->client->title
                    ) ? $result->client->title : '';
                    $singleInformation['client.first_name']  = !empty(
                        $result->client->first_name
                    ) ? $result->client->first_name : '';
                    $singleInformation['client.last_name']   = !empty(
                        $result->client->last_name
                    ) ? $result->client->last_name : '';
                    $singleInformation['client.address1']    = !empty(
                        $result->client->contactdetails[0]->address1
                    ) ? $result->client->contactdetails[0]->address1 : '';
                    $singleInformation['client.address2']    = !empty(
                        $result->client->contactdetails[0]->address2
                    ) ? $result->client->contactdetails[0]->address2 : '';
                    $singleInformation['client.address3']    = !empty(
                        $result->client->contactdetails[0]->address3
                    ) ? $result->client->contactdetails[0]->address3 : '';
                    $singleInformation['client.town']        = !empty(
                        $result->client->contactdetails[0]->town
                    ) ? $result->client->contactdetails[0]->town : '';
                    $singleInformation['client.county']      = !empty(
                        $result->client->contactdetails[0]->county
                    ) ? $result->client->contactdetails[0]->county : '';
                    $singleInformation['client.postal_code'] = !empty(
                        $result->client->contactdetails[0]->postal_code
                    ) ? $result->client->contactdetails[0]->postal_code : '';
                    $singleInformation['client.telephone']   = !empty(
                        $result->client->contactdetails[0]->telephone
                    ) ? '0' . $result->client->contactdetails[0]->telephone : '';
                    $singleInformation['client.mobile']      = !empty(
                        $result->client->contactdetails[0]->mobile
                    ) ? '0' . $result->client->contactdetails[0]->mobile : '';
                    $singleInformation['client.email']       = !empty(
                        $result->client->contactdetails[0]->email
                    ) ? $result->client->contactdetails[0]->email : '';
                    $singleInformation['optin.date']         = !empty($result->created_at) ? $result->created_at : '';


                    $singleInformation['client.landline-mobile']
                        = !empty($result->client->contactdetails[0]->telephone)
                        ? $result->client->contactdetails[0]->telephone
                        : $result->client->contactdetails[0]->mobile;

                    $singleInformation['client.mobile-landline']
                        = !empty($result->client->contactdetails[0]->mobile)
                        ? $result->client->contactdetails[0]->mobile
                        : $result->client->contactdetails[0]->telephone;

                } else {
                    $singleInformation = $resultArray[$result->lead_id];
                }


                if (isset($singleInformation[Str::slug($result->question->name)])) {
                    $currentAnswers = $singleInformation[Str::slug($result->question->name)];

                    if (is_array($currentAnswers)) {
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


        $returnResult = [];
        foreach ($results as $r)
        {
            $returnResult[$r['agent']['full_name']][$r['status']]
                = (!isset($returnResult[$r['agent']['full_name']][$r['status']]))
                ? 1
                : $returnResult[$r['agent']['full_name']][$r['status']] + 1;
        }


        $returnResults = new Collection();
        foreach ($returnResult as $agentName => $r)
        {
            $returnResults->push([
                'Agent Name' => $agentName,
                'Completed Surveys' => isset($r['COMPLETE']) ? $r['COMPLETE'] : 0,
                'Partial Surveys' => isset($r['PARTIAL']) ? $r['PARTIAL'] : 0,
            ]);
        }

        return $returnResults->sortByDesc(function($r) {
            return $r['Completed Surveys'];
        });
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
        $results = $this->repository->countCompletedScriptsByDate($scriptId, $dateFrom, $dateTo, $status);

        $returnArray = new Collection($results->toArray());

        return $returnArray;
    }
}
