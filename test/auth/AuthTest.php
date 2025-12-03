<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../fonctions/login_fonction.php';
class Auth extends TestCase
{
    protected function setUp(): void
    {
        $pdo = connectDB();
        $pdo -> exec("SET FOREIGN_KEY_CHECKS=0;");
        $pdo->exec("TRUNCATE TABLE utilisateur");
        $pdo -> exec("SET FOREIGN_KEY_CHECKS=1;");
        $hash = password_hash("testpassword", PASSWORD_BCRYPT);
        $pdo->exec("INSERT INTO utilisateur (nom, prenom, adresse, phone, email, motdepasse) VALUES ('Test', 'User', '123 Test St', '1234567890', 'test@example.com', '$hash')");
    }

    public function testUserExists()
    {
        $user = getUser('test@example.com', '1234567890');
        $this->assertFalse($user);
        $userExist = getUser('client@client', 'client');
        $this->assertTrue($userExist !== false);
    }

   /* public function testPassword()
    {
        $user = getUser('test@example.com', '1234567890');

        $this->assertTrue('client@client',password_verify('client', $user['motdepasse']));
        $this->assertFalse('test@example', password_verify('wrongpassword', $user['motdepasse']));

    }*/
     

}
?>

