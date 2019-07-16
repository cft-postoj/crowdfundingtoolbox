<?php


namespace Modules\UserManagement\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;

class DidNotPayUsersExport implements FromCollection
{

    public function __construct()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 2000);
    }

    /**
     * @return array
     */
    public function collection()
    {

    }

}