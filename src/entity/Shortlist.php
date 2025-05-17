<?php

require_once('Database.php');
require_once('CleanerService.php');

class Shortlist
{
    protected int $homeownerID;     // Logged in Homeowner ID
    protected int $serviceID;       // Service ID Selected
    protected string $category;     // Service Category
    protected string $serviceName;  // Service Name
    protected string $cleanerName;  // Cleaner Name
    protected float $price;         // Price of Service

    /**
     * Inserts New Shortlist
     *
     * @param int $homeownerID Logged in Homeowner ID
     * @param int $serviceID ID of Service Selected
     *
     * @return bool Returns true on success, false on failure.
     */
    public function newShortlist(int $homeownerID, int $serviceID): bool
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $sql = "INSERT INTO Shortlist (homeownerID, serviceID)
                    VALUES (:homeownerID, :serviceID)";

            // Execute Statement
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(":homeownerID", $homeownerID);
            $stmt->bindParam(":serviceID", $serviceID);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Execute Success, Increment Shortlist Count, Return true
            // Otherwise, return false
            if ($execResult) {
                // Increment CleanerService Shortlist Count
                $CleanerServiceObject = new CleanerService();
                $CleanerServiceObject->incrementShortlistsCount($serviceID);
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database insert failed: " . $e->getMessage());
            unset($db_handle);
            return false;
        }
    }

    /**
     * Selects All CleanerService by Homeowner ID
     *
     * @param int $homeownerID Logged in Homeowner ID
     *
     * @return ?array Array of Shortlists Object if success, null otherwise
     */
    public function viewAllShortlist(int $homeownerID): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $sql = "SELECT
                        s.homeownerID AS homeownerID,
                        cs.id AS serviceID,
                        sc.category AS category,
                        cs.serviceName AS serviceName,
                        ua.fullName AS cleanerName,
                        cs.price AS price
                    FROM Shortlist s
                    LEFT JOIN CleanerService cs ON s.serviceID = cs.id
                    LEFT JOIN ServiceCategory sc ON cs.serviceCategoryID = sc.id
                    LEFT JOIN UserAccount ua ON cs.cleanerID = ua.id
                    WHERE s.homeownerID = :homeownerID";

            // Execute Statement
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(":homeownerID", $homeownerID);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Shortlist');
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
     * Selects a CleanerService by Homeowner ID, ServiceID
     *
     * @param int $homeownerID  Logged in Homeowner ID
     * @param int $serviceID    Selected Service ID
     *
     * @return ?array Shortlists Object if success, null otherwise
     */
    public function viewShortlist(int $homeownerID, int $serviceID): ?Shortlist
    {

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $sql = "SELECT
                        s.homeownerID AS homeownerID,
                        cs.id AS serviceID,
                        sc.category AS category,
                        ua.fullName AS cleanerName,
                        cs.price AS price,
                        cs.serviceName AS serviceName
                    FROM Shortlist s
                    LEFT JOIN CleanerService cs ON s.serviceID = cs.id
                    LEFT JOIN ServiceCategory sc ON cs.serviceCategoryID = sc.id
                    LEFT JOIN UserAccount ua ON cs.cleanerID = ua.id
                    WHERE s.homeownerID = :homeownerID
                    AND s.serviceID = :serviceID";

            // Execute Statement
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(":homeownerID", $homeownerID);
            $stmt->bindParam(":serviceID", $serviceID);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If success, increment service view count, return Shortlist Object
            // Otherwise, return null
            if ($execResult) {
                $cleanerServiceObject = new CleanerService();
                $cleanerServiceObject->incrementViewCount($serviceID);
                return $stmt->fetchObject('Shortlist');
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
     * Searches for Shortlist:
     * @param int $homeownerID  Logged in Homeowner ID
     * @param int $searchTerm   Search Term
     *
     * @return ?array An array of Shortlist objects if found, null otherwise.
     */
    public function searchShortlist(int $homeownerID, string $searchTerm): ?array
    {

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Add Wildcard Operators to Search Term
            $searchTerm = "%" . $searchTerm . "%";

            // SQL Statement
            $sql = "SELECT
                        s.homeownerID AS homeownerID,
                        cs.id AS serviceID,
                        sc.category AS category,
                        ua.fullName AS cleanerName,
                        cs.price AS price,
                        cs.serviceName AS serviceName
                    FROM Shortlist s
                    LEFT JOIN CleanerService cs ON s.serviceID = cs.id
                    LEFT JOIN ServiceCategory sc ON cs.serviceCategoryID = sc.id
                    LEFT JOIN UserAccount ua ON cs.cleanerID = ua.id
                    WHERE s.homeownerID = :homeownerID
                    AND (ua.fullName LIKE :searchTerm
                    OR sc.category LIKE :searchTerm
                    OR cs.serviceName LIKE :searchTerm)";


            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(":homeownerID", $homeownerID);
            $stmt->bindParam(":searchTerm", $searchTerm);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // execute() Success?
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'Shortlist');
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
    public function getHomeownerID(): int
    {
        return $this->homeownerID;
    }

    public function getServiceID(): int
    {
        return $this->serviceID;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function getCleanerName(): string
    {
        return $this->cleanerName;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}