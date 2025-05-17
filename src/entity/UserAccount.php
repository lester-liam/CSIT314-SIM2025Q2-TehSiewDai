<?php

require_once('Database.php');

class UserAccount
{
    protected int $id;              // ID of Account
    protected string $username;     // Username (Unique)
    protected string $password;     // Password (MD5)
    protected string $fullName;     // User's Full Name
    protected string $email;        // User's Email
    protected string $phone;        // User's Phone
    protected string $userProfile;  // User Profile
    protected int $isSuspend;       // Suspend Status

    // CRUD Operations //

    /**
     * Creates a New User Account
     *
     * @param string $username      Username
     * @param string $password      Password
     * @param string $email         Email
     * @param string $phone         Phone Number
     * @param string $userProfile   User Profile
     *
     * @return bool Returns true if Create Operation Success, Else false
    */
    public function createUserAccount(
        string $username,
        string $password,
        string $fullName,
        string $email,
        string $phone,
        string $userProfile
    ): bool {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        $passwd = md5($password); // Hash Password with MD5

        // SQL TryCatch Statement
        try {
            // Bind Paramaters & Execute Statement
            $sql = "INSERT INTO `UserAccount` VALUES
                    (null, :username, :password, :fullName, :email, :phone, :userProfile, 0)";
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $passwd);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':userProfile', $userProfile);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, return true, else return null
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
     * Select User Account By ID
     * @param int $id: int
     * @return ?UserAccount Returns a UserAccount if Success, null otherwise
    */
    public function readUserAccount(int $id): ?UserAccount
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare("SELECT * FROM `UserAccount` WHERE `id` = :id");
            $stmt->bindParam(':id', $id);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, Return UserAccount Object, Else Null
            if ($execResult) {
                $userAccount = $stmt->fetchObject('UserAccount');
                return $userAccount;
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
     * Selects All for User Accounts
     * @return ?array Array of UserAccounts if success, null otherwise
    */
    public function readAllUserAccount(): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare("SELECT * FROM `UserAccount`");
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, Return Array of Objects, Otherwise Return null
            if ($execResult) {
                $userAccounts = $stmt->fetchAll(PDO::FETCH_CLASS, 'UserAccount');
                return $userAccounts;
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
     * Updates a User Account Information
     *
     * @param int $id               User Account ID
     * @param string $username      Username
     * @param ?string $password     New Password (or NULL if no updates)
     * @param string $email         Email
     * @param string $phone         Phone Number
     * @param string $userProfile   User Profile
     *
     * @return bool Returns true if Update Operation Success, Else false
    */
    public function updateUserAccount(
        int $id,
        string $username,
        ?string $password,
        string $fullName,
        string $email,
        string $phone,
        string $userProfile
    ): bool {
        // New DB Connnection
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // SQL Statement
            $sql = "UPDATE `UserAccount`
                    SET
                        `username` = :username,
                        `fullName` = :fullName,
                        `email` = :email,
                        `phone` = :phone,
                        `userProfile` = :userProfile
                    WHERE `id` = :id";

            // If Password is Provided, Update SQL Statement to Update Password
            if (!is_null($password)) {
                $sql = "UPDATE `UserAccount`
                        SET
                            `username` = :username,
                            `password` = :password,
                            `fullName` = :fullName,
                            `email` = :email,
                            `phone` = :phone,
                            `userProfile` = :userProfile
                        WHERE `id` = :id";
            }

            // Prepare Statement
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':userProfile', $userProfile);

            // Bind Password Paramater if Provided
            if (!is_null($password)) {
                $passwd = md5($password); # Hash Password
                $stmt->bindParam(':password', $passwd);
            }

            // Execute Statement
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, return true, else return false
            if ($execResult) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Update failed: " . $e->getMessage());
            unset($db_handle);
            return false;
        }
    }

    /**
     * Suspends a User Account
     * @param int $id   User Account ID
     * @return bool     Returns true if Suspend Operation Success, Else false
    */
    public function suspendUserAccount(int $id): bool
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare("UPDATE `UserAccount` SET `isSuspend` = 1 WHERE `id` = $id");
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, return true, else return false
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
     * Searches a User Account
     * @param string $searchTerm    Search Input
     * @return ?array Return Array of UserAccount Object is Success, null otherwise
    */
    public function searchUserAccount($searchTerm): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL Statement
        try {
            // Add Wildcard Search Operator
            $searchTerm = "%" . $searchTerm . "%";

            // Execute Statement
            $sql = "SELECT * FROM `UserAccount`
                    WHERE `username` LIKE :term
                    OR `fullName` LIKE :term
                    OR `email` LIKE :term
                    OR `phone` LIKE :term
                    OR `userProfile` LIKE :term";
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':term', $searchTerm);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, Return Array of UserAccount Objects, else return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'UserAccount');
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Logins a User Account, Checks if UserAccount Exists, with Valid Password
     *
     * @param string $username      Input Username
     * @param string $password      Input Password
     * @param string $userProfile   Selected UserProfile
     *
     * @return ?UserAccount Return UserAccount Object is Success, null otherwise
    */
    public function login(
        string $username,
        string $password,
        string $userProfile,
        ?PDO $mockDb
    ): ?UserAccount {
        // New DB Connnection (Mock/Real)
        if (is_null($mockDb)) {
            $db_handle = new Database();
            $db_conn = $db_handle->getConnection();
        } else {
            $db_conn = $mockDb;
        }

        // SQL Statement (+ Checks user profile isSuspend status)
        // Returns NULL if Invalid Password / No Users Found
        try {
            // Execute Statement for UserAccount
            $sql = "SELECT * FROM `UserAccount`
                    WHERE `username` = :username
                    AND `userProfile` = :userProfile";
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':userProfile', $userProfile);
            $stmt->execute();

            // Ensure Only 1 Row
            if ($stmt->rowCount() == 1) {

                // Retrieve User Account
                $userAccount = $stmt->fetchObject('UserAccount');

                // Verify Password
                if (md5($password) == $userAccount->getPassword()) {
                    $sql = "SELECT `isSuspend` FROM `UserProfile` WHERE `role` = '$userProfile'";
                    $stmt = $db_conn->query($sql);
                    $suspendStatus = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Update User Object Suspend Status if User Profile is Suspended
                    if ($suspendStatus) {
                        if ($suspendStatus['isSuspend'] == 1) {
                            $userAccount->updateIsSuspended(1);
                        }
                    }
                    unset($db_handle); // Disconnect DB
                    return $userAccount;
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

    // Accessor Methods
    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
    public function getUserProfile(): string
    {
        return $this->userProfile;
    }

    public function getSuspendStatus(): int
    {
        return $this->isSuspend;
    }

    // Mutator Methods
    // Updates 'isSuspend' Status
    protected function updateIsSuspended(int $s): void
    {
        // Update if Valid, Else Use Default (assume User is Suspended)
        if ($s == 0 | $s == 1) {
            $this->isSuspend = $s;
        } else {
            error_log("Update UserAccount isSuspend Failed (Did not Update)");
        }
    }
}