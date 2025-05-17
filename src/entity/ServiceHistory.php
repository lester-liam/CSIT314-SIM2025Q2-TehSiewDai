<?php

require_once('Database.php');

class ServiceHistory
{
    protected int $id;              // ID of Service History
    protected string $category;     // Category
    protected int $cleanerID;       // Logged in Cleaner ID
    protected int $homeownerID;     // Homeowner ID
    protected string $serviceDate;  // Date of Service History
    protected string $name;         // Either Homeowner/Cleaner Name

    /**
     * Searches for ServiceHistory records based on a category & date range
     *
     * @param int $cleanerID    Logged in Cleaner ID
     * @param string $category  Category to Filter By
     * @param int $dateOption   Selected Date Option
     *                          (0: Past 7 Days. 1: Past 30 Days, 2: All Time)
     * @return ?array An array of ServiceHistory objects if successful, null otherwise.
     */
    public function searchMatches(
        int $cleanerID,
        string $category,
        int $dateOption
    ): ?array {

        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {

            // Add Wildcard Search Operator
            $category = "%" . $category . "%";

            // SQL Statements by dateOptions
            switch ($dateOption) {
                case 0: // Past 7 Days
                    $sql = "SELECT sh.*, ua.fullName AS name
                            FROM `ServiceHistory` sh
                            LEFT JOIN `UserAccount` ua ON sh.homeownerID = ua.id
                            WHERE sh.`cleanerID` = :cleanerID
                            AND sh.`category`LIKE :category
                            AND sh.`serviceDate` >= CURDATE() - INTERVAL 7 DAY
                            ORDER BY sh.`serviceDate` DESC, sh.`category`";
                    break;
                case 1: // Past 30 Days
                    $sql = "SELECT sh.*, ua.fullName AS name
                            FROM `ServiceHistory` sh
                            LEFT JOIN `UserAccount` ua ON sh.homeownerID = ua.id
                            WHERE sh.`cleanerID` = :cleanerID
                            AND sh.`category`LIKE :category
                            AND sh.`serviceDate` >= CURDATE() - INTERVAL 30 DAY
                            ORDER BY sh.`serviceDate` DESC, sh.`category`";
                    break;
                case 2: // All Time
                    $sql = "SELECT sh.*, ua.fullName AS name
                            FROM `ServiceHistory` sh
                            LEFT JOIN `UserAccount` ua ON sh.homeownerID = ua.id
                            WHERE sh.`cleanerID` = :cleanerID
                            AND sh.`category`LIKE :category
                            ORDER BY sh.`serviceDate` DESC, sh.`category`";
                    break;
            }

            // Execute Statement
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':cleanerID', $cleanerID);
            $stmt->bindParam(':category', $category);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceHistory');
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Reads all ServiceHistory records from the database.
     * @param int $cleanerID    Logged in Cleaner ID
     * @return ?array An array of ServiceHistory objects if successful, null otherwise.
     */
    public function viewMatches(int $cleanerID): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $sql = "SELECT sh.*, ua.fullName AS name
                    FROM `ServiceHistory` sh
                    LEFT JOIN `UserAccount` ua ON sh.homeownerID = ua.id
                    WHERE sh.`cleanerID` = :cleanerID
                    ORDER BY sh.`serviceDate` DESC, sh.`category`";

            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':cleanerID', $cleanerID);

            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceHistory');
            } else {
                return null;
            }

        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Reads all category records from the database.
     * @param int $cleanerID    Logged in Cleaner ID
     * @return ?array An associative array of categories (string)
     */
    public function getCategories(int $cleanerID): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $sql =  "SELECT DISTINCT category
                    FROM ServiceHistory sh
                    WHERE cleanerID = :cleanerID";

            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':cleanerID', $cleanerID);

            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }

        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Searches for HO's ServiceHistory records based on a category & date range
     *
     * @param int $homeownerID    Logged in Homeowner ID
     * @param string $category  Category to Filter By
     * @param int $dateOption   Selected Date Option
     *                          (0: Past 7 Days. 1: Past 30 Days, 2: All Time)
     * @return ?array An array of ServiceHistory objects if successful, null otherwise.
     */
    public function searchBookings(
        int $homeownerID,
        string $category,
        int $dateOption
    ): ?array {

        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Add Wildcard Search Operator
            $category = "%" . $category . "%";

            // SQL Statements by dateOptions
            switch ($dateOption) {
                case 0: // Past 7 Days
                    $sql = "SELECT sh.*, ua.fullName AS name
                            FROM `ServiceHistory` sh
                            LEFT JOIN `UserAccount` ua ON sh.homeownerID = ua.id
                            WHERE sh.`homeownerID` = :homeownerID
                            AND sh.`category`LIKE :category
                            AND sh.`serviceDate` >= CURDATE() - INTERVAL 7 DAY
                            ORDER BY sh.`serviceDate` DESC, sh.`category`";
                    break;
                case 1: // Past 30 Days
                    $sql = "SELECT sh.*, ua.fullName AS name
                            FROM `ServiceHistory` sh
                            LEFT JOIN `UserAccount` ua ON sh.homeownerID = ua.id
                            WHERE sh.`homeownerID` = :homeownerID
                            AND sh.`category`LIKE :category
                            AND sh.`serviceDate` >= CURDATE() - INTERVAL 30 DAY
                            ORDER BY sh.`serviceDate` DESC, sh.`category`";
                    break;
                case 2: // All Time
                    $sql = "SELECT sh.*, ua.fullName AS name
                            FROM `ServiceHistory` sh
                            LEFT JOIN `UserAccount` ua ON sh.homeownerID = ua.id
                            WHERE sh.`homeownerID` = :homeownerID
                            AND sh.`category`LIKE :category
                            ORDER BY sh.`serviceDate` DESC, sh.`category`";
                    break;
            }

            // Execute Statement
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':homeownerID', $homeownerID);
            $stmt->bindParam(':category', $category);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceHistory');
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Reads all HO's ServiceHistory records from the database.
     * @param int $homeownerID    Logged in Homeowner ID
     * @return ?array An array of ServiceHistory objects if successful, null otherwise.
     */
    public function viewBookings(int $homeownerID): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $sql = "SELECT sh.*, ua.fullName AS name
                    FROM `ServiceHistory` sh
                    LEFT JOIN `UserAccount` ua ON sh.cleanerID = ua.id
                    WHERE sh.`homeownerID` = :homeownerID
                    ORDER BY sh.`serviceDate` DESC, sh.`category`";

            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':homeownerID', $homeownerID);

            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceHistory');
            } else {
                return null;
            }

        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Reads all HO's category records from the database.
     * @param int $homeownerID    Logged in Homeowner ID
     * @return ?array An associative array of categories (string)
     */
    public function getHoCategories(int $homeownerID): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $sql = "SELECT DISTINCT category
                    FROM ServiceHistory sh
                    WHERE homeownerID = :homeownerID";

            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':homeownerID', $homeownerID);

            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    // Accessor Methods
    public function getId(): int {
        return $this->id;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getCleanerID(): int
    {
        return $this->cleanerID;
    }

    public function getHomeownerID(): int
    {
        return $this->homeownerID;
    }

    public function getServiceDate(): string
    {
        return $this->serviceDate;
    }

    public function getName(): string
    {
        return $this->name;
    }
}