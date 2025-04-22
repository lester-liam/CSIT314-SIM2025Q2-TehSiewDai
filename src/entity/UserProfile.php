<?php
require_once('Database.php');

class UserProfile {
    private $id;
    private $role; 
    private $description;
    private $isSuspend;

    // Constructor Class
    public function __construct() {
        $this->id = null;
        $this->role = null;
        $this->isSuspend = null;
        $this->description = null;
    }  

    // CRUD Operations //

    //  Create User Profile
    public function createUserProfile($role, $description) {
    /*  Inserts New User Profile:
        $role: string
        $description: string

        Returns: Boolean 
    */
        
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("INSERT INTO `UserProfile` (`role`, `description`, `isSuspend`) VALUES (:role, :description, 0)");
            $stmt->bindParam(':role', $role);
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
            error_log("Database insert failed: " . $e->getMessage());
            unset($db_handle);
            return FALSE;
        }

        
    }

    //  Read UserProfile
    public function readUserProfile($id) {
    /*  Select User Profile By ID
        $id: int

    Returns: Single UserProfile 
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("SELECT * FROM `UserProfile` WHERE `id` = :id");
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

    public function readAllUserProfile() {
    /*  Select All User Profile

        Returns: Array of User Profiles
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("SELECT * FROM `UserProfile`");
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

    public function updateUserProfile($id, $role, $description) {
    /*  Updates a User Profile:

        $id: int
        $role: string
        $description: string

        Returns: Boolean
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("UPDATE `UserProfile` SET `role` = :role, `description` = :description WHERE `id` = $id");
            $stmt->bindParam(':role', $role);
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
            error_log("Database insert failed: " . $e->getMessage());
            unset($db_handle);
            return FALSE;
        }
    }
    
    public function suspendUserProfile($id) {
    /*  Suspends a User Profile:
        $id: int
        Returns: Boolean
    */
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("UPDATE `UserProfile` SET `isSuspend` = 1 WHERE `id` = $id");
            
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

    // Search User Profile
    public function searchUserProfile($searchTerm) {
    /*  Searches for User Profile(s):
        $searchTerm: string
        Returns: Array of UserProfile
    */

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();
        
        // SQL Statement
        try {
            $searchTerm = "%" . $searchTerm . "%";
            $stmt = $db_conn->prepare("SELECT * FROM `UserProfile` WHERE `role` LIKE :term OR `description` LIKE :term");
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