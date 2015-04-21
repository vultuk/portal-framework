<?php namespace Portal\Foundation\DateTime;

use Carbon\Carbon;

trait SetsCacheTimeByDateRange {

    protected $shortCacheTime = 5;
    protected $longCacheTime = 1440;

    protected function getCacheTime(Carbon $dateFrom, Carbon $dateTo, $shortCacheTime = null, $longCacheTime = null)
    {
        if ( !Carbon::now()->between($dateFrom, $dateTo) )
        {
            return !is_null($longCacheTime) ? $longCacheTime : $this->longCacheTime;
        }

        return !is_null($shortCacheTime) ? $shortCacheTime : $this->shortCacheTime;
    }

}