<?php namespace Portal\People\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Activities\Contracts\RecordsActivity;

class Person extends Model {
    use RecordsActivity;

    protected static $recordedEvents = ['created', 'updated'];

    protected $connection = "portal/framework";

    protected $table = "people";

    protected $fillable = [
        'title',
        'first_name',
        'middle_names',
        'last_name',
        'date_of_birth'
    ];

    public function activity()
    {
        return $this->morphMany('\Portal\Activities\Models\Activity', 'link')->with(['activity', 'link'])->latest();;
    }

    public function addresses()
    {
        return $this->morphMany('\Portal\ContactDetails\Models\Address', 'link');
    }

    public function numbers()
    {
        return $this->morphMany('\Portal\ContactDetails\Models\TelephoneNumber', 'link');
    }

    public function extracontactdetails()
    {
        return $this->morphMany('\Portal\ContactDetails\Models\ExtraContactDetail', 'link');
    }

    public function orders()
    {
        return $this->morphMany('\Portal\Orders\Models\Order', 'link');
    }

}