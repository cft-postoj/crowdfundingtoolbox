<?php


namespace Modules\UserManagement\Services;

use Modules\UserManagement\Exports\DonorsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;


class Export2CsvService
{

    private $donorsExport;

    public function __construct(DonorsExport $donorsExport)
    {
        $this->donorsExport = $donorsExport;
    }

    public function export($request) {
        $valid = validator($request->only(
            'data',
            'type'
        ), [
            'data' => 'required',
            'type' => 'string'
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        $filename = "export.csv";
        $handle = fopen($filename, 'w+');
        switch ($request['type']) {
            case 'donors':
                foreach($this->donorsExport->collection() as $row) {
                    fputcsv($handle, $row);
                }
                break;
            case 'stopped-supporting':

                break;
            case 'didnt-pay-users':

                break;
            case 'not-complete-support':

                break;
        }

        fclose($handle);
        return Response::download($filename, 'donors-export.csv', $headers);

    }
}