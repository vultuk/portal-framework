<?php namespace Portal\Users\Controllers\Reports;

use Carbon\Carbon;
use IlluminateExtensions\Routing\Controller;
use IlluminateExtensions\Support\Collection;
use Portal\Foundation\Color\CanConvertColors;
use Portal\Foundation\DateTime\SetsStartAndEndDate;
use Portal\Users\Contracts\UserRepository;
use Portal\Users\Requests\Reports\Sales\SelectUserFormRequest;
use Portal\Scripts\Contracts\ReportRepository as ScriptReport;

class SalesReportController extends Controller {
    use SetsStartAndEndDate, CanConvertColors;

    protected $user;

    function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function index()
    {
        return $this->view('users.reports.index', [
            'userList' => $this->user->getUserList(),
        ]);
    }

    public function viewDetails(SelectUserFormRequest $request, ScriptReport $scriptReport)
    {
        $inputs = $request->all();

        $this->setStartDate(new Carbon($inputs['start_date']))->setEndDate(new Carbon($inputs['end_date']));

        $userStatistics = new Collection();
        $possibleDates = [];

        array_map(function($user) use(&$userStatistics, &$possibleDates, $scriptReport) {
            $scriptStatistics = $scriptReport->getSurveyCountByAgentId(
                $this->user->getDiallerId($user), $this->getStartDate(), $this->getEndDate()
            );

            foreach (array_keys($scriptStatistics) as $key)
            {
                $possibleDates[] = $key;
            }

            $color = [];
            list($color['r'], $color['g'], $color['b']) = $this->hex2rgb(sprintf("#%06x",rand(0,16777215)));

            $userStatistics->push([
                'user' => $this->user->getUserDetails($user),
                'color' => $color,
                'scriptStatistics' => $scriptStatistics,
            ]);
        }, $inputs['user_id']);


        return $this->view('users.reports.view', [
            'statistics' => $userStatistics,
            'possibleDates' => array_unique($possibleDates),
        ]);
    }

}