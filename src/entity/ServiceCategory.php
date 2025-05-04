<?php
require_once('Database.php');

class ServiceCategory {

    protected int $id;
    protected string $category;
    protected string $description;

    // CRUD Operations //

    //  Create ServiceCategory
    public function createServiceCategory(string $category, ?string $description): bool {
    /*  Inserts New Service Category:
        $category: string
        $description: string

        Returns: Boolean 
    */
        
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {

            $sql = "INSERT INTO `ServiceCategory` (`category`) VALUES (:category)";
            
            // Checks if Description is NULL
            if (!is_null($description)) {
                $sql = "INSERT INTO `ServiceCategory` (`category`, `description`) VALUES (:category, :description)";
            }

            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':category', $category);

            if (!is_null($description)) {
                $stmt->bindParam(':description', $description);
            }

            $execResult = $stmt->execute();
            
            unset($db_handle); // Delete DB Conn

            // Insert Success ?
            if ($execResult) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            error_log("Database insert failed: " . $e->getMessage());
            unset($db_handle);
            return FALSE;
        }

        
    }

    //  Read ServiceCategory
    public function readServiceCategory(int $id): ?ServiceCategory  {
    /*  Select Service Category By ID
        $id: int

        Returns: Single ServiceCategory (nullable)
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("SELECT * FROM `ServiceCategory` WHERE `id` = :id");
            $stmt->bindParam(':id', $id);
            $execResult = $stmt->execute();
            
            unset($db_handle); // Delete DB Conn
            
            // execute() Success?
            if ($execResult) {
                $serviceCategory = $stmt->fetchObject('ServiceCategory');
                return $serviceCategory;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
        
    }

    public function readAllServiceCategory(): ?array {
    /*  Select All ServiceCategory

        Returns: Array of ServiceCategory (nullable)
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("SELECT * FROM `ServiceCategory`");
            $execResult = $stmt->execute();
            unset($db_handle); // Delete DB Conn

            // execute() Success?
            if ($execResult) {
                // Execute was successful, now fetch the data
                $serviceCategory = $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceCategory');
                return $serviceCategory;
            } else {
                return null;
            }

        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
        
    }

    public function updateServiceCategory(int $id, string $category, ?string $description): bool {
    /*  Updates a Service Category:

        $id: int
        $category: string
        $description: string

        Returns: Boolean
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {

            $sql = "UPDATE `ServiceCategory` SET `category` = :category, `description` = :description WHERE `id` = $id";
            
            // Checks if Description is NULL
            if (is_null($description)) {
                $description = 'No Description';
            }

            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':description', $description);
            
            $execResult = $stmt->execute();
    
            unset($db_handle); // Delete DB Conn

            // Insert Success ?
            if ($execResult) {
                return TRUE;
            } else {
                return FALSE;
            }

        } catch (PDOException $e) {
            error_log("Database update failed: " . $e->getMessage());
            unset($db_handle);
            return FALSE;
        }
    }
    
    public function deleteServiceCategory(int $id): bool {
    /*  Deletes a Service Category:
        $id: int
        Returns: Boolean
    */
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("DELETE FROM `ServiceCategory` WHERE `id` = $id");
            
            $execResult = $stmt->execute();
    
            unset($db_handle); // Delete DB Conn

            // Insert Success ?
            if ($execResult) {
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            error_log("Database delete failed: " . $e->getMessage());
            unset($db_handle);
            return FALSE;
        }
    }

    // Search Service Category
    public function searchServiceCategory(string $searchTerm): ?array {
    /*  Searches for ServiceCategory:
        $searchTerm: string
        Returns: Array of ServiceCategory (nullable)
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();
        
        // SQL Statement
        try {
            $searchTerm = "%" . $searchTerm . "%";
            $stmt = $db_conn->prepare("SELECT * FROM `ServiceCategory` WHERE `category` LIKE :term OR `description` LIKE :term");
            $stmt->bindParam(':term', $searchTerm);
            $execResult = $stmt->execute();
            unset($db_handle); // Delete DB Conn

            // Search Success ?
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'ServiceCategory');
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            return null;
        }
    }

    // Accessor Methods
    public function getId(): int { return $this->id; }
    public function getCategory(): string { return $this->category; }
    public function getDescription(): string { return $this->description; }

}
?>