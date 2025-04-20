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

    //  Create Service
    public function createUserProfile($serviceName, $serviceCategory) {
        
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

    //  Read Service Category
    public function readServiceCategory($id) {
        
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

    //  Read All Services
    public function readAllServiceCategory() {
    
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

    // Update Service Category
    public function updateServiceCategory($id, $serviceName, $serviceCategory) {

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("UPDATE `ServiceCategory` SET `serviceName` = :serviceName, `serviceCategory` = :serviceCategory WHERE `id` = $id");
            $stmt->bindParam(':serviceName', $serviceName);
            $stmt->bindParam(':serviceCategory', $serviceCategory);
            $execResult = $stmt->execute();
            
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

    // Search Services
    public function searchServiceCategory($searchTerm) {

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