<?php

require_once('Database.php');

class CleanerService
{
    protected int $id;                  // ID of Cleaner Service
    protected int $serviceCategoryID;   // Service Category ID
    protected int $cleanerID;           // Cleaner ID
    protected string $serviceName;      // Service Name
    protected float $price;             // Price of Service
    protected int $numViews;            // Number of Service Views
    protected int $numShortlists;       // Number of Shortlist Count
    protected string $createdAt;        // Created At Datetime
    protected string $updatedAt;        // Updated At Datetime
    protected string $category;         // Service Category (String)
    protected string $cleanerName;      // Cleaner Name

    /**
     * Inserts New CleanerService
     *
     * @param int $serviceCategoryID The ID of the service category.
     * @param int $cleanerID The ID of the cleaner.
     * @param string $serviceName The name of the service.
     * @param float $price The price of the service.
     *
     * @return bool Returns true on success, false on failure.
     */
    public function createCleanerService(
        int $serviceCategoryID,
        int $cleanerID,
        string $serviceName,
        float $price
    ): bool {

        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // SQL Statement
            $sql = "INSERT INTO `CleanerService`
                    (`serviceCategoryID`, `cleanerID`, `serviceName`, `price`)
                    VALUES (
                        :serviceCategoryID, :cleanerID, :serviceName, :price
                    )";

            // Bind Parameters
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':serviceCategoryID', $serviceCategoryID);
            $stmt->bindParam(':cleanerID', $cleanerID);
            $stmt->bindParam(':serviceName', $serviceName);
            $stmt->bindParam(':price', $price);

            // Execute Statement
            $execResult = $stmt->execute();

            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return true
            // Otherwise, return false
            if ($execResult) {
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
     * Reads a specific CleanerService record by ID + CleanerID
     *
     * @param int $id The ID of the cleaner service.
     * @param int $cleanerID The ID of the cleaner.
     *
     * @return ?CleanerService The CleanerService object if found, null otherwise.
     */
    public function viewCleanerService(int $id, int $cleanerID): ?CleanerService
    {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare(
                "SELECT cs.*, sc.category
                FROM CleanerService cs
                INNER JOIN ServiceCategory sc
                ON cs.serviceCategoryID = sc.id
                WHERE cs.id = :id
                AND cs.cleanerID = :cleanerID"
            );
            // Bind Paramaters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':cleanerID', $cleanerID);
            $execResult = $stmt->execute();

            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return object
            // Otherwise, return null
            if ($execResult) {
                $cleanerService = $stmt->fetchObject('CleanerService');
                return $cleanerService;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Selects All CleanerService by CleanerID
     * @param int $cleanerID The ID of the cleaner.
     * @return ?array An array of CleanerService objects if successful, null otherwise.
     */
    public function viewAllCleanerService(int $cleanerID): ?array
    {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare(
                "SELECT cs.*, sc.category
                FROM CleanerService cs
                INNER JOIN ServiceCategory sc
                ON cs.serviceCategoryID = sc.id
                WHERE cs.cleanerID = :cleanerID"
            );
            $stmt->bindParam(':cleanerID', $cleanerID);
            $execResult = $stmt->execute();

            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            if ($execResult) {
                // Execute was successful, now fetch the data
                $cleanerService = $stmt->fetchAll(
                                            PDO::FETCH_CLASS, 'CleanerService'
                                         );
                return $cleanerService;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Updates a Cleaner Service
     *
     * @param int $id The ID of the cleaner service to update.
     * @param int $cleanerID The ID of the cleaner.
     * @param string $serviceName The new name of the service.
     * @param float $price The new price of the service.
     *
     * @return bool Returns true on success, false on failure.
     */
    public function updateCleanerService(
        int $id,
        int $cleanerID,
        string $serviceName,
        float $price
    ): bool {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $sql = "UPDATE `CleanerService`
                    SET `serviceName` = :serviceName, `price` = :price
                    WHERE `id` = $id AND `cleanerID` = $cleanerID";
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':serviceName', $serviceName);
            $stmt->bindParam(':price', $price);
            $execResult = $stmt->execute();

            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return true
            // Otherwise, return false
            if ($execResult) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database update failed: " . $e->getMessage());
            unset($db_handle);
            return false;
        }
    }

    /**
     * Deletes a CleanerService
     *
     * @param int $id The ID of the cleaner service to delete.
     * @param int $cleanerID The ID of the cleaner. (from Session)
     *
     * @return bool Returns true on success, false on failure.
     */
    public function deleteCleanerService(int $id, int $cleanerID): bool
    {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare(
                "DELETE FROM `CleanerService`
                WHERE `id` = $id
                AND `cleanerID` = $cleanerID
            ");
            $execResult = $stmt->execute();

            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return true
            // Otherwise, return false
            if ($execResult) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database delete failed: " . $e->getMessage());
            unset($db_handle);
            return false;
        }
    }

    /**
     * Searches for CleanerSerivce:
     * @param int $cleanerID The ID of the cleaner.
     * @param string $searchTerm The search term.
     *
     * @return ?array An array of CleanerService objects if found, null otherwise.
     */
    public function searchCleanerService(
        int $cleanerID,
        string $searchTerm
    ): ?array {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Add Wildcard Operators to Search Term
            $searchTerm = "%" . $searchTerm . "%";

            // SQL Statement
            $stmt = $db_conn->prepare(
                "SELECT cs.*, sc.category
                FROM CleanerService cs
                INNER JOIN ServiceCategory sc
                ON cs.serviceCategoryID = sc.id
                WHERE cs.cleanerID = :cleanerID
                AND (sc.category LIKE :term
                OR cs.serviceName LIKE :term)"
            );
            // Bind Parameters
            $stmt->bindParam(':cleanerID', $cleanerID);
            $stmt->bindParam(':term', $searchTerm);

            // Execute Statement
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'CleanerService');
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Select Number of Views for a CleanerService
     * @param int $id The ID of the cleaner service.
     * @return int Returns the number of views for the cleaner service.
     */
    public function getViewCount(int $id): int
    {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare(
                "SELECT `numViews`
                 FROM `CleanerService`
                 WHERE `id` = $id"
            );
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return int
            // Else return default value (0)
            if ($execResult) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return (int) $result['numViews'];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return 0;
        }
    }

    /**
     * Select Number of Shortlists for a CleanerService
     * @param int $id The ID of the cleaner service.
     * @return int Returns the number of shortlists for a cleaner service
     */
    public function getShortlistCount(int $id): int
    {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare(
                "SELECT `numShortlists`
                FROM `CleanerService`
                WHERE `id` = $id"
            );
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return int
            // Else return default value (0)
            if ($execResult) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return (int) $result['numShortlists'];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return 0;
        }
    }

    /**
     * Select All CleanerService (Homeowner View)
     * @return ?array An array of all CleanerService objects if successful, null otherwise.
     */
    public function hoViewAllService(): ?array
    {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare(
                "SELECT cs.*,
                sc.category AS category,
                ua.fullName AS cleanerName
                FROM `CleanerService` cs
                LEFT JOIN `UserAccount` ua ON cs.cleanerID = ua.id
                LEFT JOIN `ServiceCategory` sc ON cs.serviceCategoryID = sc.id"
            );
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            if ($execResult) {
                $cleanerService = $stmt->fetchAll(
                                            PDO::FETCH_CLASS, 'CleanerService'
                                         );
                return $cleanerService;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    /**
     * Select a CleanerService (Homeowner View)
     * @param int $id The ID of Cleaner Service
     * @return ?CleanerService An object of CleanerService if found, null otherwise.
     */
    public function hoViewService(int $id): ?CleanerService
    {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare(
                "SELECT cs.*,
                sc.category AS category,
                ua.fullName AS cleanerName
                FROM `CleanerService` cs
                LEFT JOIN `UserAccount` ua ON cs.cleanerID = ua.id
                LEFT JOIN `ServiceCategory` sc ON cs.serviceCategoryID = sc.id
                WHERE cs.id = :id"
            );
            $stmt->bindParam(':id', $id);
            $execResult = $stmt->execute();

            // execute() Success?
            if ($execResult) {

                $cleanerService = $stmt->fetchObject('CleanerService');
                $cleanerService->incrementViewCount($id);

                return $cleanerService;

            } else {
                unset($db_handle); // Disconnect DB Conn
                return null;
            }

        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }

    }

    /**
     * Search for CleanerService by Search Term (Homeowner View)
     * @param string $searchTerm Search Term to Search
     * @return ?array An array of CleanerService Objects if successful, null otherwise
     */
    public function hoSearchService(string $searchTerm): ?array
    {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Add Wildcard Operators to Search Term
            $searchTerm = "%" . $searchTerm . "%";

            // SQL Statement
            $stmt = $db_conn->prepare(" SELECT cs.*,
                                        sc.category AS category,
                                        ua.fullName AS cleanerName
                                        FROM `CleanerService` cs
                                        LEFT JOIN `UserAccount` ua
                                            ON cs.cleanerID = ua.id
                                        LEFT JOIN `ServiceCategory` sc
                                            ON cs.serviceCategoryID = sc.id
                                        WHERE ua.fullName LIKE :searchTerm
                                        OR sc.category LIKE :searchTerm
                                        OR cs.serviceName LIKE :searchTerm
                                    ");

            // Execute Statement
            $stmt->bindParam(":searchTerm", $searchTerm);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If execution was sucessful, return fetchAll objects
            // Otherwise, return null
            if ($execResult) {
                $cleanerService = $stmt->fetchAll(PDO::FETCH_CLASS, 'CleanerService');
                return $cleanerService;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }

    // Accessor Methods
    public function getId(): int
    {
        return $this->id;
    }

    public function getServiceCategoryID(): int
    {
        return $this->serviceCategoryID;
    }

    public function getCleanerID(): int
    {
        return $this->cleanerID;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }
    public function getPrice(): float
    {
        return $this->price;
    }

    public function getNumViews(): int
    {
        return $this->numViews;
    }

    public function getNumShortlists(): int
    {
        return $this->numShortlists;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getCleanerName(): string
    {
        return $this->cleanerName;
    }

    // Mutator Methods
    /**
     * Increments View Count of CleanerService by 1
     * @return void
     */
    public function incrementViewCount(int $id): void
    {
        // SQL Statement
        $sql = "UPDATE CleanerService SET numViews = numViews + 1 WHERE id = :id";

        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Error, Log
            if (!$execResult) {
                error_log("Database update failed");
            }
        } catch (PDOException $e) {
            error_log("Database update failed: " . $e->getMessage());
            unset($db_handle);
        }
    }

    /**
     * Increments Shortlist Count of CleanerService by 1
     * @param int $serviceID ID of CleanerService
     * @return void
     */
    public function incrementShortlistsCount(int $serviceID): void
    {
        // SQL Statement
        $sql = "UPDATE CleanerService SET numShortlists = numShortlists + 1 WHERE id = :id";

        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(":id", $serviceID);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Error, Log
            if (!$execResult) {
                error_log("Database update failed");
            }
        } catch (PDOException $e) {
            error_log("Database update failed: " . $e->getMessage());
            unset($db_handle);
        }
    }
}