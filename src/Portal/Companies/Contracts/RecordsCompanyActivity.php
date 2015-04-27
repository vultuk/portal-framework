<?php namespace Portal\Companies\Contracts;

use Portal\Companies\Models\CompanyActivity;
use ReflectionClass;

trait RecordsCompanyActivity {

    protected static function bootRecordsCompanyActivity()
    {

        foreach (static::getModelEvents() as $event)
        {
            static::$event(function($model) use($event) {
                $model->recordEvent($event);
            });
        }

    }

    public function recordEvent($event)
    {
        $className = strtolower((new ReflectionClass($this))->getShortName());

        CompanyActivity::create([
            'company_id' => $className == "company" ? $this->id : $this->company_id,
            'activity_id' => $this->id,
            'activity_type' => get_class($this),
            'activity_name' => $this->getActivityName($this, $event),
        ]);
    }

    protected function getActivityName($model, $action)
    {
        $name = strtolower((new ReflectionClass($model))->getShortName());

        return "{$action}_{$name}";
    }

    protected static function getModelEvents()
    {
        return isset(static::$recordedEvents) ?
            static::$recordedEvents :
            ['created', 'updated', 'deleted'];
    }

}