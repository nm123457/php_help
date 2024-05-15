<?php
	// Csak akkor indítunk session-t, ha még nem fut
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class DatabaseFunc {
	public static $dbServer = "localhost";
	public static $dbName = "due";
	public static $dbUser = "root";
	public static $dbPass = "";
		
	public static function dbConnect()
    {
        $conn = new mysqli(self::$dbServer, self::$dbUser, self::$dbPass, self::$dbName);
        if ($conn->connect_error) {
            return null;
        } else {
            return $conn;
        }
    }
	
	public function userCreate()
    {
        try {
            $userLogin = "mark";
            $userPass =  hash("sha512", "abc123");

			
				$sqlQuery = "INSERT INTO login (username, password)
                VALUES ('$userLogin', '$userPass');";
				self::dbConnect()->query($sqlQuery);
				echo 'User sikeresen létrehozva';
			
        } catch (Exception $e) {
            echo "Kivétel dobva: " . $e->getMessage();
        } finally {
				self::dbConnect()->close();
			}
    }
}

class SessionFunctions
{
    public static function sessionDelete()
    {
        session_unset();
    }

    public static function setUserID($userID)
    {
        $_SESSION["felhasznaloID"] = $userID;
    }

    public static function getUserID()
    {
        return $_SESSION["felhasznaloID"];
    }

    public static function setUserLogin($userLogin)
    {
        $_SESSION["felhasznaloLogin"] = $userLogin;
    }

    public static function getUserLogin()
    {
        return $_SESSION["felhasznaloLogin"];
    }
}

class SQLfunctions
{
    //Adatbázis authentikációs/kapcsolat adatok
    private static $dbServer = "localhost";
    private static $dbName = "due";
    private static $dbUser = "student";
    private static $dbPass = "student";

    public static function dbConnect()
    {
        $connect = new mysqli(self::$dbServer, self::$dbUser, self::$dbPass, self::$dbName);
        if ($connect->connect_error) {
            return null;
        } else {
            return $connect;
        }
    }

    public static function adminUserCreate()
    {
        try {
            $userLogin = "admin";
            $userFull = "Adminisztrátor";
            $userPass =  hash("sha512", "Pass1234");
            $userCreated = date("Y.m.d H:i:s");

            $sqlCheck = "SELECT Login FROM users WHERE Login='admin';";

            $result = self::dbConnect()->query($sqlCheck);

            if ($result->num_rows == 0) {
                $sqlQuery = "INSERT INTO users (FullName, Login, Password, Registered)
                VALUES ('$userFull', '$userLogin', '$userPass', '$userCreated');";
                self::dbConnect()->query($sqlQuery);
                echo "Sikeres az admin user létrehozása!";
            } else {
                echo "Az admin felhasználó már létezik!";
            }
            self::dbConnect()->close();
        } catch (Exception $e) {
            echo "Hiba lépett fel az admin user létrehozásakor. Hiba: " . $e->getMessage();
        }
    }
}
?>