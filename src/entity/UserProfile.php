<?php

require_once('Database.php');

class UserProfile
{
    protected int $id;                  // Profile ID
    protected string $role;             // Role or Profile Name
    protected string $description;      // Description of Role
    protected int $isSuspend;           // Suspend Status

    // CRUD Operations //

    /**
     * Creates a New User Profile
     *
     * @param string $role          Profile/Role Name
     * @param string $description   Description of Role
     *
     * @return bool Returns true if Create Operation Success, Else false
    */
    public function createUserProfile(string $role, string $description): bool
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $sql = "INSERT INTO `UserProfile` (`role`, `description`, `isSuspend`)
                    VALUES (:role, :description, 0)";
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':description', $description);
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
     * Select User Profile By ID
     * @param int $id: int
     * @return ?UserProfile Returns a UserProfile if Success, null otherwise
    */
    public function readUserProfile(int $id): ?UserProfile
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare("SELECT * FROM `UserProfile` WHERE `id` = :id");
            $stmt->bindParam(':id', $id);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, Return UserProfile Object, Else Null
            if ($execResult) {
                $userProfile = $stmt->fetchObject('UserProfile');
                return $userProfile;
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
     * Selects All for User Profile
     * @return ?array Array of UserProfile if success, null otherwise
    */
    public function readAllUserProfile(): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $stmt = $db_conn->prepare("SELECT * FROM `UserProfile`");
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, Return Array of Objects, Otherwise Return null
            if ($execResult) {
                $userProfile = $stmt->fetchAll(PDO::FETCH_CLASS, 'UserProfile');
                return $userProfile;
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
     * Updates a User Profile Information
     *
     * @param int $id               User Profile ID
     * @param string $role          New Role/Profile Name
     * @param string $description   New Description
     *
     * @return bool Returns true if Update Operation Success, Else false
    */
    public function updateUserProfile(int $id, string $role, string $description): bool
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // SQL Statement
            $stmt = $db_conn->prepare(
                "UPDATE `UserProfile`
                SET
                    `role` = :role,
                    `description` = :description
                WHERE `id` = $id"
            );

            // Bind Parameters
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':description', $description);

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
            error_log("Database insert failed: " . $e->getMessage());
            unset($db_handle);
            return false;
        }
    }

    /**
     * Suspends a User Profile
     * @param int $id   User Profile ID
     * @return bool     Returns true if Suspend Operation Success, Else false
    */
    public function suspendUserProfile(int $id): bool
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL TryCatch Statement
        try {
            // Execute Statement
            $sql = "UPDATE `UserProfile` SET `isSuspend` = 1 WHERE `id` = $id";
            $stmt = $db_conn->prepare($sql);
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
     * Searches a User Profile
     * @param string $searchTerm    Search Input
     * @return ?array Array of UserProfile Object is Success, null otherwise
    */
    public function searchUserProfile(string $searchTerm): ?array
    {
        // New DB Conn
        $db_handle = new Database();
        $db_conn = $db_handle->getConnection();

        // SQL Statement
        try {
            // Add Wildcard Search Operator
            $searchTerm = "%" . $searchTerm . "%";

            // Execute Statement
            $sql = "SELECT * FROM `UserProfile`
                    WHERE `role` LIKE :term OR `description` LIKE :term";
            $stmt = $db_conn->prepare($sql);
            $stmt->bindParam(':term', $searchTerm);
            $execResult = $stmt->execute();
            unset($db_handle); // Disconnect DB Conn

            // If Success, Return Array of UserProfile Objects, else return null
            if ($execResult) {
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'UserProfile');
            } else {
                return null;
            }
        } catch (PDOException $e) {
            error_log("Database search failed: " . $e->getMessage());
            return null;
        }
    }

    // Accessor  Methods
    public function getId(): int
    {
        return $this->id;
    }
    public function getRole(): string
    {
        return $this->role;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSuspendStatus(): int
    {
        return $this->isSuspend;
    }
}