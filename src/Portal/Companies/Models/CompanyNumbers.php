<?php namespace Portal\Companies\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Companies\Contracts\RecordsCompanyActivity;

class CompanyNumbers extends Model {
    use RecordsCompanyActivity;

    protected $connection = "portal/framework";

    protected $table = "company_numbers";

    protected $fillable = [
        'company_id',
        'description',
        'number',
    ];

    protected function company()
    {
        return $this->belongsTo('\Portal\Companies\Models\Company');
    }

}