<?php

require_once("/var/www/html/entity/Report.php");

class ViewMonthlyReportController
{
    private $report;

    public function __construct()
    {
        $this->report = new Report();
    }

    public function getMonthlyReport(): ?array
    {
        return $this->report->getMonthlyReport();
    }
}