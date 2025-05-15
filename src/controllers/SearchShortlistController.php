<?php

require_once("/var/www/html/entity/Shortlist.php");

class SearchShortlistController
{
    private $shortlist;

    public function __construct()
    {
        $this->shortlist = new Shortlist();
    }

    public function searchShortlist(int $homeownerID, string $searchTerm): ?array
    {
        return $this->shortlist->searchShortlist($homeownerID, $searchTerm);
    }
}