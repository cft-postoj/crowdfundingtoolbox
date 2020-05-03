<?php


namespace Modules\UserManagement\Services;

use Modules\UserManagement\Exports\DidNotPayUsersExport;
use Modules\UserManagement\Exports\DonorsExport;
use Illuminate\Support\Facades\Response;
use Modules\UserManagement\Exports\NotCompleteSupportExport;
use Modules\UserManagement\Exports\StoppedSupportingExport;


class Export2CsvService
{

    private $donorsExport;
    private $stoppedSupportingExport;
    private $notCompleteSupportExport;
    private $didNotPayUsersExport;

    public function __construct(DonorsExport $donorsExport, StoppedSupportingExport $stoppedSupportingExport,
                                NotCompleteSupportExport $notCompleteSupportExport, DidNotPayUsersExport $didNotPayUsersExport)
    {
        $this->donorsExport = $donorsExport;
        $this->stoppedSupportingExport = $stoppedSupportingExport;
        $this->notCompleteSupportExport = $notCompleteSupportExport;
        $this->didNotPayUsersExport = $didNotPayUsersExport;
    }

    public function export($request)
    {
        $valid = validator($request->only(
            'type'
        ), [
            'type' => 'required|string'
        ]);
        if ($valid->fails()) {
            $jsonError = response()->json([
                'error' => $valid->errors()
            ], Response::HTTP_BAD_REQUEST);
            return $jsonError;
        }
        $from = $request['from'];
        $to = $request['to'];

        $headers = array(
            'Content-Type' => 'text/csv',
        );
        $filename = 'export.csv';
        $handle = fopen($filename, 'w+');
        switch ($request['type']) {
            case 'donors':
                foreach ($this->donorsExport->collection() as $row) {
                    fputcsv($handle, $row);
                }
                break;
            case 'stopped-supporting':
                foreach ($this->stoppedSupportingExport->getData($from, $to) as $row) {
                    fputcsv($handle, $row);
                }
                break;
            case 'didnt-pay':
                foreach ($this->didNotPayUsersExport->getData($from, $to) as $row) {
                    fputcsv($handle, $row);
                }
                break;
            case 'not-complete-support':
                foreach ($this->notCompleteSupportExport->getData($from, $to) as $row) {
                    fputcsv($handle, $row);
                }
                break;
            case 'gift-donors':
                foreach ($this->donorsExport->donorsGiftExport() as $row) {
                    fputcsv($handle, $row);
                }
                break;
        }

        fclose($handle);
        return Response::download($filename, 'donors-export.csv', $headers);

    }
}