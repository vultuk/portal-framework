<?php namespace Portal\ContactDetails\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class ExtraContactDetail extends Model {
    use RecordsActivity;

    protected $connection = "portal/framework";

    protected $table = "extra_contact_details";

    protected $fillable = [
        'description',
        'information',
    ];

    protected function link()
    {
        return $this->morphTo();
    }

}