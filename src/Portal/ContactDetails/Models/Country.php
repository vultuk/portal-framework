<?php namespace Portal\ContactDetails\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    protected $connection = "portal/framework";

    protected $table = "countries";

    protected $fillable = [
        'name',
    ];

}