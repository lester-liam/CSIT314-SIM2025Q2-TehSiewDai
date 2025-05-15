<?php

require_once("/var/www/html/entity/Report.php");

class ViewDailyReportController
{
    private $report;

    public function __construct()
    {
        $this->report = new Report();
    }

    public function getDailyReport(): ?array
    {
        return $this->report->getDailyReport();
    }
}