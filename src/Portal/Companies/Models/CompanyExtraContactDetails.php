<?php namespace Portal\Companies\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Companies\Contracts\RecordsCompanyActivity;

class CompanyExtraContactDetails extends Model {
    use RecordsCompanyActivity;

    protected $connection = "portal/framework";

    protected $table = "company_extra_contact_details";

    protected $fillable = [
        'company_id',
        'description',
        'information',
    ];

    protected function company()
    {
        return $this->belongsTo('\Portal\Companies\Models\Company');
    }

}