<?php namespace Portal\ContactDetails\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class Address extends Model {
    use RecordsActivity;

    protected $connection = "portal/framework";

    protected $table = "addresses";

    protected $fillable = [
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


    public function link()
    {
        return $this->morphTo();
    }

}