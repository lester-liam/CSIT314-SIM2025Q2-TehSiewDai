<?php

require_once ("/var/www/html/entity/Shortlist.php");

class ViewAllShortlistController
{
    private $shortlist;

    public function __construct()
    {
        $this->shortlist = new Shortlist();
    }

    public function viewAllShortlist(int $homeownerID): ?array
    {
        return $this->shortlist->viewAllShortlist($homeownerID);
    }
}