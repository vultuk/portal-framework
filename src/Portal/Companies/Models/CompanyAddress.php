<?php namespace Portal\Companies\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Companies\Contracts\RecordsCompanyActivity;

class CompanyAddress extends Model {
    use RecordsCompanyActivity;

    protected $connection = "portal/framework";

    protected $table = "company_addresses";

    protected $fillable = [
        'company_id',
        'description',
        'address1',
        'address2',
        'town_city',
        'county',
        'postal_code',
        'country',
        'latitude',
        'longitude',
    ];


    public function company()
    {
        return $this->belongsTo('Portal\Companies\Models\Company');
    }

}