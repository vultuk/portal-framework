<?php namespace Portal\Activities\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model {

    protected $connection = "portal/framework";

    protected $table = "activities";

    protected $fillable = [
        'link_id',
        'link_type',
        'activity_id',
        'activity_type',
        'activity_name',
    ];

    public function link()
    {
        return $this->morphTo();
    }

    public function activity()
    {
        return $this->morphTo();
    }

}