<?php namespace Portal\Companies\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Companies\Contracts\RecordsCompanyActivity;
use Portal\Foundation\Eloquent\ConnectsToPortalDatabase;

class Company extends Model {
    use RecordsCompanyActivity;

    protected static $recordedEvents = ['created', 'updated'];

    protected $connection = "portal/framework";

    protected $table = "companies";

    protected $fillable = [
        'name',
        'slug',
        'logo',
    ];

    public function activity()
    {
        return $this->hasMany('\Portal\Companies\Models\CompanyActivity')->with('activity')->latest();;
    }

    public function addresses()
    {
        return $this->hasMany('\Portal\Companies\Models\CompanyAddress');
    }

    public function numbers()
    {
        return $this->hasMany('\Portal\Companies\Models\CompanyNumbers');
    }

    public function extracontactdetails()
    {
        return $this->hasMany('\Portal\Companies\Models\CompanyExtraContactDetails');
    }

}