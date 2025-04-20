<?php
require_once('Database.php');

class UserAccount {
    private $id;
    private $username; 
    private $password;
    private $fullName;
    private $email;
    private $phone;
    private $userProfile;
    private $isSuspend;

    // Constructor Class
    public function __construct() {
        $this->id = null;
        $this->username = null;
        $this->password = null;
        $this->fullName = null;
        $this->email = null;
        $this->phone = null;
        $this->userProfile = null;
        $this->isSuspend = null;
    }  

    // CRUD Operations //

    //  Create User
    public function createUserAccount($username, $password, $fullName, $email, $phone, $userProfile) {
        
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();
        

        // Hash Password with MD5
        $passwd = md5($password);

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("INSERT INTO `UserAccount` VALUES (null, :username, :password, :fullName, :email, :phone, :userProfile, 0)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $passwd);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':userProfile', $userProfile);
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

    //  Read User
    public function readUserAccount($id) {
        
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("SELECT * FROM `UserAccount` WHERE `id` = :id");
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

    //  Read All User
    public function readAllUserAccount() {
    
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            $stmt = $db_conn->prepare("SELECT * FROM `UserAccount`");
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

    // Update User
    public function updateUserAccount($id, $username, $password, $fullName, $email, $phone, $userProfile, $isSuspend) {

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();


        // SQL TryCatch Statement
        try {
            $sql = "UPDATE `UserAccount` SET `username` = :username, `fullName` = :fullName, `email` = :email, `phone` = :phone, `userProfile` = :userProfile, `isSuspend` = :isSuspend WHERE `id` = :id";

            if (!is_null($password)) {
                $sql = "UPDATE `UserAccount` SET `username` = :username, `password` = :password, `fullName` = :fullName, `email` = :email, `phone` = :phone, `userProfile` = :userProfile, `isSuspend` = :isSuspend WHERE `id` = :id";
            }

            $stmt = $db_conn->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':userProfile', $userProfile);
            $stmt->bindParam(':isSuspend', $isSuspend);

            if (!is_null($password)) {
                $passwd = md5($password);
                $stmt->bindParam(':password', $passwd);
            }

            $execResult = $stmt->execute();

            unset($db_handle); // Delete DB Conn

            // Update Success ?
            if ($execResult) {
                error_log("Database Update Success");
                error_log(print_r($execResult, true)); // Use print_r for better debugging
                return TRUE;
            } else {
                return FALSE;
            }
        } catch (PDOException $e) {
            error_log("Database Update failed: " . $e->getMessage());
            unset($db_handle);
            return FALSE;
        }
        
    }

    // Search User Account
    public function searchUserAccount($searchTerm) {

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();
        
        // SQL Statement
        try {
            $searchTerm = "%" . $searchTerm . "%";
            $stmt = $db_conn->prepare("SELECT * FROM `UserAccount` WHERE `username` LIKE :term OR `fullName` LIKE :term OR `email` LIKE :term OR `phone` LIKE :term OR `userProfile` LIKE :term");
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

    // Authenticate User
    public function login($username, $password, $userProfile) {

        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL Statement (+ Checks user profile isSuspend status)
        // Returns NULL if Invalid Password / No Users Found
        try {
            $stmt = $db_conn->prepare("SELECT * FROM `UserAccount` WHERE `username` = :username AND `userProfile` = :userProfile");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':userProfile', $userProfile);
            
            $stmt->execute();

            // Ensure Only 1 Row
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verify Password
                if (md5($password) == $user["password"]) {
                    $sql = "SELECT `isSuspend` FROM `UserProfile` WHERE `role` = '$userProfile'";
                    $stmt = $db_conn->query($sql);
                    $suspendStatus = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Update User Object Suspend Status if User Profile is Suspended
                    if ($suspendStatus) {
                        if ($suspendStatus['isSuspend'] == 1) {
                            $user['isSuspend'] = 1;
                        }
                    }

                    unset($db_handle);
                    
                    return $user;
                } else {
                    return null;
                }

            } else {
                unset($db_handle);
                return null;
            }
            
        } catch (PDOException $e) {
            error_log("Database query failed: " . $e->getMessage());
            unset($db_handle);
            return null;
        }
    }
}
?>