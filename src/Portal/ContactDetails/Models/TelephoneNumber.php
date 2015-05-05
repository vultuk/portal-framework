<?php namespace Portal\ContactDetails\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class TelephoneNumber extends Model {
    use RecordsActivity;

    protected $connection = "portal/framework";

    protected $table = "telephone_numbers";

    protected $fillable = [
        'description',
        'number',
    ];

    protected function link()
    {
        return $this->morphTo();
    }

}