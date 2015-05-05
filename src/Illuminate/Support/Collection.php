<?php namespace IlluminateExtensions\Support;

use Illuminate\Support\Collection as BaseCollection;
use Maatwebsite\Excel\Facades\Excel;

class Collection extends BaseCollection
{

    protected $excelStoragePath = 'emails/foundation/collection/toemail';

    public function toEmail(array $to)
    {
        \Mail::send('portal::emails.foundation.collection.toemail', [], function($message) use($to)
        {
            $filename = 'TestFile';
            $xl = $this->toXls($filename, false, 'Password!');

            $message->to($to);
            $message->subject('Just Testing');
            $message->from('noreply@mysecureportal.net', 'My Secure Portal');
            $message->attach(storage_path($this->excelStoragePath) . '/' . $filename . '.xls');
        });
    }


    public function transformWithHeadings($headings)
    {
        $newCollection = new Collection();

        foreach ($this as $item)
        {
            $returnArray = [];

            foreach ($headings as $key => $value)
            {
                 $returnArray[$value] = $item[$key];
            }

            $newCollection->push($returnArray);
        }

        return $newCollection;
    }

    public function toXls($filename, $export = true, $password = null)
    {
        $excel = Excel::create($filename, function($excel) use($password) {
            $excel->sheet('Results', function($sheet) use($password) {
                $sheet->fromArray($this->toArray());
                if (!is_null($password))
                {
                    $sheet->protect($password);
                }
            });
        });

        return $export ? $excel->export('xls') : $excel->store('xls', storage_path($this->excelStoragePath));
    }


}