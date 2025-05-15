<?php

require_once("/var/www/html/entity/Report.php");

class ViewWeeklyReportController
{
    private $report;

    public function __construct()
    {
        $this->report = new Report();
    }

    public function getWeekyReport(): ?array
    {
        return $this->report->getWeekyReport();
    }
}