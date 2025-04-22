<?php
require_once("./entity/Database.php");

try {
	
	// New DB Conn
	$db_handle = new Database();
	$db_conn = $db_handle->getConnection();

    // get the role of the userprofile table
    $roleStmt = $db_conn->query("SELECT role FROM UserProfile");
    $roles = $roleStmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Check if roles are empty – if yes, stop the script - can delete
    if (empty($roles)) {
        throw new Exception(" UserProfile is empty");
    }

    // 2. insert user
    for ($i = 2; $i <= 101; $i++) {
        $username = "u$i";
        $password = md5($username); 
        $fullname = $username;
        $email = $username . "@email.com";
        $phone = strval(rand(80000000, 99999999));
        $userProfile = $roles[array_rand($roles)];
        $isSuspend = 0;

        // check the user in db or not ,
        $checkStmt = $db_conn->prepare("SELECT COUNT(*) FROM UserAccount WHERE username = :username");
        $checkStmt->execute([':username' => $username]);
        $exists = $checkStmt->fetchColumn();

        if ($exists > 0) {
            echo "Skipped: $username already exists\n";
            continue;
        }

        // insert user
        $stmt = $db_conn->prepare("INSERT INTO UserAccount (username, password, fullName, email, phone, userProfile, isSuspend) 
									VALUES (:username, :password, :fullName, :email, :phone, :userProfile, :isSuspend)");
        $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':fullName' => $fullname,
            ':email' => $email,
            ':phone' => $phone,
            ':userProfile' => $userProfile,
            ':isSuspend' => $isSuspend
        ]);

        echo "✅ Inserted: $username ($userProfile)\n";
    }

    //result show
    echo "\ninserting test users successfully.\n";
	
	unset($db_conn);

} catch (PDOException $e) {
    echo "PDO Error: " . $e->getMessage();
	unset($db_conn);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
	unset($db_conn);
}
?>
