<?php

class Database {

    private $db_conn;

    public function __construct() {

        // Temporary Certificate File Path
        $caPath = "../tmp/ca.pem";

        // Write Environment Variable to File (Base64 Decode)
        if (getenv('DB_SSL_CA_B64')) {
            file_put_contents($caPath, base64_decode(getenv('DB_SSL_CA_B64')));
        }

        $uri = getenv('DB_URI');
        $fields = parse_url($uri);
        $conn = "mysql:";
        $conn .= "host=" . $fields["host"];
        $conn .= ";port=" . $fields["port"];;
        $conn .= ";dbname=csit314";
        $conn .= ";sslmode=verify-ca;sslrootcert=../tmp/ca.pem";
        $this->db_conn = new PDO($conn, $fields["user"], $fields["pass"]);

        // Enable ANSI_QUOTES for this session
        $this->db_conn->exec("SET SESSION sql_mode = 'ANSI_QUOTES'");
    }

    public function getConnection() {
        return $this->db_conn;
    }

    public function __destruct() {
        $this->db_conn = null;
    }
}