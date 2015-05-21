<?php namespace Portal\Foundation\DateTime;

use Carbon\Carbon;

/**
 * Accepts setting the start and end date. if nothing is set
 *
 * Class SetsStartAndEndDate
 *
 * @package Portal\Foundation\DateTime
 */
trait SetsStartAndEndDate {

    /**
     * Storage for the Start Date
     *
     * @var null
     */
    protected $startDate = null;

    /**
     * Storage for the End Date
     *
     * @var null
     */
    protected $endDate = null;

    /**
     * Sets the Start Date
     *
     * @param \Carbon\Carbon $startDate
     *
     * @return $this
     */
    public function setStartDate(Carbon $startDate = null)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Sets the End Date
     *
     * @param \Carbon\Carbon $endDate
     *
     * @return $this
     */
    public function setEndDate(Carbon $endDate = null)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Gets the Start Date
     *
     * @return null
     */
    public function getStartDate()
    {
        if (is_null($this->startDate))
        {
            $this->setStartDate( Carbon::now()->hour(0)->minute(0)->second(0) );
        }

        return $this->startDate;
    }

    /**
     * Gets the End Date
     *
     * @return null
     */
    public function getEndDate()
    {
        if (is_null($this->endDate))
        {
            $this->setEndDate( Carbon::now()->hour(23)->minute(59)->second(59) );
        }

        return $this->endDate;
    }

}