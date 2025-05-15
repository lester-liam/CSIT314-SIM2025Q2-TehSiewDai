<?php

require_once '/var/www/html/controllers/LoginController.php';
require_once '/var/www/html/entity/UserAccount.php';

// PHPUnit Testing for Login
class LoginTest extends PHPUnit\Framework\TestCase
{
    private $mockDb;

    protected function setUp(): void {
        // Use Test DB for Database Connection
        $this->mockDb = new PDO("mysql:host=db;dbname=csit314_test", "root", "csit314");
    }

    // Test 1: Valid Login
    public function testLoginSuccess()
    {
        fwrite(STDOUT, "Running testLoginSuccess...\n");
        $controller = new LoginController();
        $result = $controller->login('u1', 'u1', 'User Admin', $this->mockDb);

        if (is_null($result)) {
            error_log("Result is null");
        }

        $this->assertInstanceOf(UserAccount::class, $result);
        fwrite(STDOUT, "testLoginSuccess: Assertion passed\n");
    }

    // Test 2: Suspended User Profile
    public function testSuspendedProfile()
    {
        fwrite(STDOUT, "Running testSuspendedProfile...\n");
        $controller = new LoginController();
        $result = $controller->login('u2', 'u2', 'Homeowner', $this->mockDb);

        $this->assertInstanceOf(UserAccount::class, $result);
        $this->assertEquals(1, $result->getSuspendStatus());
        fwrite(STDOUT, "testSuspendedProfile: Assertions passed\n");
    }

    // Test 3: Suspended User Account
    public function testSuspendedAccount()
    {
        fwrite(STDOUT, "Running testSuspendedAccount...\n");
        $controller = new LoginController();
        $result = $controller->login('u3', 'u3', 'Cleaner', $this->mockDb);

        $this->assertInstanceOf(UserAccount::class, $result);
        $this->assertEquals(1, $result->getSuspendStatus());
        fwrite(STDOUT, "testSuspendedAccount: Assertions passed\n");
    }

    // Test 4: Invalid Credentials
    public function testLoginFail()
    {
        fwrite(STDOUT, "Running testLoginFail...\n");
        $controller = new LoginController();
        $result = $controller->login('u100', 'ab12cde', 'Us3r Adm1n', $this->mockDb);

        $this->assertNull($result);
        fwrite(STDOUT, "testLoginFail: Assertion passed\n");
    }

    // Close DB Connection After Each Test
    protected function tearDown(): void {
        $this->mockDb = null;
    }
}