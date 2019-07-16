<?php


namespace Modules\UserManagement\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;

class NotCompleteSupportExport implements FromCollection
{
    private $from;
    private $to;

    public function __construct()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 2000);
    }

    public function getData($from, $to) {
        $this->from = $from;
        $this->to = $to;
        return $this->collection();
    }

    /**
     * @return array
     */
    public function collection()
    {

    }

}