<?php

namespace App\Reports;

class ReportGenerator
{
    public function generateReport(Report $report, $format = 'pdf')
    {
        $data = $report->generate();
        return $report->export($format);
    }
}
