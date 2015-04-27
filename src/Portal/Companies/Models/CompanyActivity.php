<?php namespace Portal\Companies\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyActivity extends Model {

    protected $connection = "portal/framework";

    protected $table = "company_activities";

    protected $fillable = [
        'company_id',
        'activity_id',
        'activity_type',
        'activity_name',
    ];

    public function activity()
    {
        return $this->morphTo();
    }

}