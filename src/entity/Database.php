<?php

class Database
{
    private $db_conn;

    public function __construct()
    {
        $this->db_conn = new PDO("mysql:host=db;dbname=csit314", "root", "csit314");
    }

    public function getConnection()
    {
        return $this->db_conn;
    }

    public function __destruct()
    {
        $this->db_conn = null;
    }
}