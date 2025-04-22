<?php
require_once('Database.php');

class ServiceCategory {
    private $id;
    private $serviceName; 
    private $serviceCategory;

    // Constructor Class
    public function __construct() {
        $this->id = null;
        $this->serviceName = null;
        $this->serviceCategory = null;
    }  

    // CRUD Operations //

    //  Create ServiceCategory
    public function createServiceCategory($serviceName, $serviceCategory) {
    /*  Inserts New User Profile:
        $serviceName: string
        $serviceCategory: string

        Returns: Boolean 
    */
        
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("INSERT INTO `ServiceCategory` (`serviceName`, `serviceCategory`) VALUES (:serviceName, :serviceCategory)");
            $stmt->bindParam(':serviceName', $serviceName);
            $stmt->bindParam(':serviceCategory', $serviceCategory);
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
    public function readServiceCategory($id) {
    /*  Select Service Category By ID
        $id: int

    Returns: Single ServiceCategory 
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
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
        
    }

    public function readAllServiceCategory() {
    /*  Select All ServiceCategory

        Returns: Array of ServiceCategory
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
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $users;
            }

        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
        
    }

    public function updateServiceCategory($id, $serviceName, $serviceCategory) {
    /*  Updates a User Profile:

        $id: int
        $serviceName: string
        $serviceCategory: string

        Returns: Boolean
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("UPDATE `ServiceCategory` SET `serviceName` = :serviceName, `serviceCategory` = :serviceCategory WHERE `id` = $id");
            $stmt->bindParam(':serviceName', $serviceName);
            $stmt->bindParam(':serviceCategory', $serviceCategory);
            
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
    
    public function deleteServiceCategory($id) {
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
    public function searchServiceCategory($searchTerm) {
    /*  Searches for ServiceCategory:
        $searchTerm: string
        Returns: Array of ServiceCategory
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();
        
        // SQL Statement
        try {
            $searchTerm = "%" . $searchTerm . "%";
            $stmt = $db_conn->prepare("SELECT * FROM `ServiceCategory` WHERE `serviceName` LIKE :term OR `serviceCategory` LIKE :term");
            $stmt->bindParam(':term', $searchTerm);
            $execResult = $stmt->execute();
            unset($db_handle); // Delete DB Conn

            // Search Success ?
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            return null;
        }
    }
}
?>