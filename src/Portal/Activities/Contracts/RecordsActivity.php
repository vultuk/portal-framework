<?php namespace Portal\Activities\Contracts;

use Portal\Activities\Models\Activity;
use ReflectionClass;

trait RecordsActivity {

    protected static function bootRecordsActivity()
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

        Activity::create([
            'link_id' => isset($this->link_type) ? $this->link_id : $this->id,
            'link_type' => isset($this->link_type) ? $this->link_type : get_class($this),
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