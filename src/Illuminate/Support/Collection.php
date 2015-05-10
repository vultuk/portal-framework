<?php namespace IlluminateExtensions\Support;

use Carbon\Carbon;
use Illuminate\Support\Collection as BaseCollection;
use Maatwebsite\Excel\Facades\Excel;

class Collection extends BaseCollection
{

    protected $excelStoragePath = 'emails/foundation/collection/toemail';

    public function limit($top, $start = null)
    {
        if ($top == 0 && is_null($start))
        {
            return $this;
        }

        $newCollection = new Collection();

        $i = 1;
        foreach ($this as $single)
        {
            if (is_null($start) || $i >= $start)
            {
                $newCollection->push($single);
            }

            if ( $i < $top || $top == 0 )
            {
                $i++;
            } else {
                break;
            }

        }

        return $newCollection;
    }

    public function toUrl(array $settings)
    {

        $postedResults = new Collection();
        $this->each(function($item) use($settings, &$postedResults) {

            $data = http_build_query( array_merge($settings['defaults'], $item) );

            if ($settings['method'] == 'POST')
            {
                $result = file_get_contents($settings['url'], false, stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $data,
                    ]
                ]));
            }
            else
            {
                $result = file_get_contents($settings['url'] . '?' . $data);
            }

            $item[strtolower($settings['method']) . '_result'] = $result;

            $postedResults->push($item);
        });

        // If email settings are available pass on the completed data set
        if (isset($settings['to']) && isset($settings['filename']) && isset($settings['subject']))
        {
            $postedResults->toEmail([
                'to' => $settings['to'],
                'subject' => $settings['subject'],
                'filename' => $settings['filename'],
            ]);
        }

        return $postedResults;
    }

    public function toEmail(array $settings)
    {
        \Mail::send('portal::emails.foundation.collection.toemail', [
            'title' => $settings['subject'],
            'total' => $this->count(),
        ], function($message) use($settings)
        {
            $filename = $settings['filename'] . '_' . Carbon::now()->format('YmdHis');
            $xl = $this->toXls($filename, false);

            $message->to($settings['to']);
            $message->subject($settings['subject'] . ' - ' . Carbon::now()->format('d/m/Y'));
            $message->from('noreply@mysecureportal.net', 'My Secure Portal');
            $message->attach(storage_path($this->excelStoragePath) . '/' . $filename . '.xls');
        });

        return $this;
    }


    public function transformWithHeadings($headings)
    {
        $newCollection = new Collection();

        foreach ($this as $item)
        {
            $returnArray = [];

            foreach ($headings as $key => $value)
            {
                 $returnArray[$value] = isset($item[$key]) ? $item[$key] : false;
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
