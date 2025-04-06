<?php
include('Database.php');

class User {
    private $id;
    private $username;
    private $fullName;
    private $password;
    private $email;
    private $phone;
    private $userProfile;
    private $isSuspend;

    // Constructor
    public function __construct($username = null, $fullName = null, $password = null, $email = null, $phone = null, $userProfile = null, $isSuspend = null) {
        $this->id = null;
        $this->username = $username;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phone = $phone;
        $this->userProfile = $userProfile;
        $this->isSuspend = $isSuspend;
    }  

    // CRUD Operations //

    //  Create User
    public function createUser() {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL Statement
        $sql = "INSERT INTO `User` VALUES(null, $this->username, $this->password, $this->fullName, $this->email, $this->phone, $this->userProfile)";
        
        $db_conn->exec($sql);

        unset($db_handle);
    }

    // Suspend User

    // Authenticate User
    public function auth() {
        
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();
       
        // SQL Statement
        $sql = "SELECT * FROM `User` WHERE `username` = '$this->username' AND `userProfile` = '$this->userProfile'";
    
        // Execute the query
        $stmt = $db_conn->query($sql);

        // Check if a user is found
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);  // Get the user data from the query
            // Verify the password (assuming the stored password is hashed using password_hash)
            if ($this->password == $user["password"]) {
                unset($db_handle);
                return $user;
            } else {
                unset($db_handle);
                $user = array('id' => -1);
                return $user;
            }
        } else {
            unset($db_handle);
            $user = array('id' => -1);
            return $user;
        }
    }
}

?>