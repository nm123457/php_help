<?php

// Csak akkor indítunk session-t, ha még nem fut
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class SessionFunctions
{
    public static function sessionDelete()
    {
        session_unset();
        session_destroy();
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

    public static function setUserFullName($userFull)
    {
        $_SESSION["felhasznaloFull"] = $userFull;
    }

    public static function getUserFullName()
    {
        return $_SESSION["felhasznaloFull"];
    }

    public static function setAccess($userJog)
    {
        $_SESSION["userJog"] = $userJog;
    }

    public static function getAccess()
    {
        return $_SESSION["userJog"];
    }
}

class BasicFunctions
{
    public static function createLog($logText)
    {
        try {
            $conn = SQLfunctions::dbConnect();
            $datetimeNow = date("Y.m.d H:i:s");
            $sqlQ = "INSERT INTO Logs (Login, Message, LogTime)
            values('System','$logText','$datetimeNow');";
            $conn->query($sqlQ);
            $conn->close();
        } catch (Exception $e) {
            FajlMuveletek::exportLogToTXT($datetimeNow . " - Hiba: " . $e->getMessage());
        }
    }

    public static function getIpAddressUser()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    // Speciális karakterek eltávolítása
    public static function removeAllSpecialCharacter($string)
    {
        // Reguláris kifejezéssel kiszedjük a speciális karaktereket, kivéve a "_" jelet
        return preg_replace('/[^A-Za-z0-9\_]/', '', $string);
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

            $sqlCheck = "SELECT UserID FROM userLogin WHERE UserID='admin';";

            $result = self::dbConnect()->query($sqlCheck);

            if ($result->num_rows == 0) {
                $sqlQuery = "INSERT INTO userLogin (Nev, UserID, PassW, CreatedDT, Access)
                VALUES ('$userFull', '$userLogin', '$userPass', '$userCreated','admin');";
                self::dbConnect()->query($sqlQuery);
                echo "Sikeres admin user létrehozás!";
            } else {
                echo "Az admin felhasználó már létezik!";
            }
            self::dbConnect()->close();
        } catch (Exception $e) {
            BasicFunctions::createLog("Hiba lépett fel az admin user létrehozásakor. Hiba: " . $e->getMessage());
        }
    }

    public static function addUser($login, $fullName, $passWD, $access)
    {
        try {
            $userPass =  hash("sha512", $passWD);
            $clearLogin = BasicFunctions::removeAllSpecialCharacter($login);
            $userCreated = date("Y.m.d H:i:s");

            $sqlCheck = "SELECT UserID FROM userLogin WHERE UserID='$clearLogin';";

            $result = self::dbConnect()->query($sqlCheck);

            if ($result->num_rows == 0) {
                $sqlQuery = "INSERT INTO userLogin (Nev, UserID, PassW, CreatedDT, Access)
                VALUES ('$fullName', '$clearLogin', '$userPass', '$userCreated','$access');";
                self::dbConnect()->query($sqlQuery);
                echo "<div><h1>Felhasználó sikeresen létrehozva! (" . $clearLogin . ")!</h1></div>";
            } else {
                echo "<div><h1>A megadott felhasználónév már létezik (" . $clearLogin . ")!</h1></div>";
            }
            self::dbConnect()->close();
        } catch (Exception $e) {
            BasicFunctions::createLog("Hiba lépett fel a(z) " . $clearLogin . " felhasználó létrehozásakor! Hiba: " . $e->getMessage());
        }
    }

    public static function usersTablazat()
    {
        $table = "userLogin";
        $sql = "SELECT * FROM $table
        ORDER BY CreatedDT DESC";

        if (self::dbConnect()) {
            $result = self::dbConnect()->query($sql);

            if ($result->num_rows > 0) {
                echo "<div><table id='sajatTable'>";

                // Tábla header kiírása
                echo "
                <th style='text-align: center'>Login</th>
                <th style='text-align: center'>Név</th>
                <th style='text-align: center'>Jogosultság</th>
                <th style='text-align: center'>Regisztráció dátuma</th>";

                // Jöhetnek a rekordok
                echo "<tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='text-align: left'>" . $row["UserID"] . "</td>";
                    echo "<td style='text-align: left'>" . $row["Nev"] . "</td>";
                    echo "<td style='text-align: left'>" . $row["Access"] . "</td>";
                    echo "<td style='text-align: left'>" . $row["CreatedDT"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            }
            self::dbConnect()->close();
        } else {
            BasicFunctions::createLog("SQL kapcsolat NOK! " . mysqli_connect_error());
        }
    }

    // Pagination funkció
    private static function pagingTablazat($start, $end, $isExport)
    {
        $table = "userIP";
        $table2 = "userLogin";

        $sql = "SELECT U.*,L.Nev FROM $table AS U
        LEFT JOIN $table2 AS L ON L.UserID=U.UserID
        ORDER BY LoginDT DESC LIMIT $start, $end";

        $sqlM = "SELECT ID, UserID, IP, LoginDT FROM $table ORDER BY LoginDT ASC";

        if (self::dbConnect()) {

            $resultSor = self::dbConnect()->query($sqlM);
            $result = self::dbConnect()->query($sql);
            $eredmeny = $result;

            if ($result->num_rows > 0) {
                echo "<div><table id='sajatTable'>";
                echo "
                <th style='text-align: center'>ID</th>
                <th style='text-align: center'>Felhasználó</th>
                <th style='text-align: center'>Név</th>
                <th style='text-align: center'>IP cím</th>
                <th style='text-align: center'>Bejelentkezett</th>";
                if (SessionFunctions::getAccess() == "admin") {
                    echo "<th style='text-align: center'>Törlés</th>";
                }
                echo "<tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='text-align: left'>" . $row["ID"] . "</td>";
                    echo "<td style='text-align: left'>" . $row["UserID"] . "</td>";
                    echo "<td style='text-align: left'>" . $row["Nev"] . "</td>";
                    echo "<td style='text-align: left'>" . $row["IP"] . "</td>";
                    echo "<td style='text-align: left'>" . $row["LoginDT"] . "</td>";
                    // Ha admin, akkor jöhet a törlés link
                    if (SessionFunctions::getAccess() == "admin") {
                        echo "<td style='text-align: center'><a href='../delete.php?ID=" . $row["ID"] . "'>Törlés</a></td>";
                    }
                    echo "</tr>";
                }

                echo "</table>";

                $prev = $start - $end;

                // Csak akkor van előző oldal, ha volt következő
                if ($prev >= 0) {
                    echo "<button onclick=\"location.href='" . $_SERVER['PHP_SELF'] . "?page=" . $prev . "'\" class='lapozoButton'>Előző</button>";
                }

                // Csak addig, amíg elérjük a rekord végét
                if ((int)$_GET['page'] < $resultSor->num_rows - $end) {
                    echo "<button style='' onclick=\"location.href='" . $_SERVER['PHP_SELF'] . "?page=" . ($start + $end) . "'\" class='lapozoButton'>Következő</button>";
                }
            }
            if ($isExport) {
                $sqlEx = "SELECT * FROM $table";
                $resultX = self::dbConnect()->query($sqlEx);
                FajlMuveletek::exportToCSV($resultX, "LoginokExport");
                FajlMuveletek::exportToXML($resultX, "LoginokExport");
            }
            self::dbConnect()->close();
        } else {
            BasicFunctions::createLog("SQL kapcsolat NOK! " . mysqli_connect_error());
        }
        return $eredmeny;
    }

    // Táblázat rajzolásának meghívása lapozó vizsgálattal
    public static function getPagingTablazat($lapozasMerteke, $isExport = false)
    {
        // Megnézzük, hogy mivel kezdünk, mivel az első link esetén az érték 0 bagy NULL lesz
        if (!isset($_GET['page']) or !is_numeric($_GET['page'])) {
            $start = 0;
        } else {
            $start = (int)$_GET['page'];
        }
        // Hozzászólások megjelenítése/listázása
        return self::pagingTablazat($start, $lapozasMerteke, $isExport);
    }

    // Bejelentkezés
    public static function login($userLogin, $passWord)
    {
        try {
            $table = "userLogin";
            $userPass = hash('sha512', $passWord);
            $clearLogin = BasicFunctions::removeAllSpecialCharacter($userLogin);

            // Adatok lekérdezése adatbázisból
            $sql = "SELECT * FROM $table WHERE UserID='$clearLogin' and PassW='$userPass'";

            $result = self::dbConnect()->query($sql);

            if ($result->num_rows > 0) {
                // Minden rekordot lekérdezünk (igaz itt csak egy érték lesz)
                while ($row = $result->fetch_assoc()) {
                    SessionFunctions::setUserLogin($row["UserID"]);
                    SessionFunctions::setUserFullName($row["Nev"]);
                    SessionFunctions::setAccess($row["Access"]);
                }
                self::saveIpAddressSql($userLogin);
                self::dbConnect()->close();
                header("location: index.php");
            } else {
?>
                <div>
                    <h2>Sikertelen bejelentkezés!</h2>
                </div>
<?php
            }
        } catch (Exception $e) {
            BasicFunctions::createLog("Login sikertelen! Hiba: " . $e->getMessage());
        }
    }

    // IP címek lekérdezése
    public static function getIpAddressSql()
    {
        try {
            $table = "userIP";
            $result[] = array();
            $sql = "SELECT * FROM $table";
            $resultSQL = self::dbConnect()->query($sql);

            if ($resultSQL->num_rows > 0) {
                while ($resultSQL->fetch_assoc()) {
                    foreach ($resultSQL as $egysor) {
                        $result[] = array(
                            'ID' => $egysor['ID'],
                            'UserID' => $egysor['UserID'],
                            'IP' => $egysor['IP'],
                            'LoginDT' => $egysor['LoginDT']
                        );
                    }
                }
            }
            self::dbConnect()->close();
            return $result;
        } catch (Exception $e) {
            BasicFunctions::createLog("IP cím lekérdezése sikertelen! Hiba: " . $e->getMessage());
        }
    }

    // IP címek tárolása
    public static function saveIpAddressSql($userID)
    {
        try {
            $table = "userIP";
            $ip = BasicFunctions::getIpAddressUser();
            $sql = "INSERT INTO $table (IP,UserID) VALUES('$ip','$userID')";
            $result = self::dbConnect()->query($sql);
            self::dbConnect()->close();
            return $result;
        } catch (Exception $e) {
            BasicFunctions::createLog("IP cím mentése sikertelen! Hiba: " . $e->getMessage());
        }
    }

    // User login törlése
    public static function deleteUserLogin($id)
    {
        try {
            $table = "userIP";
            $sql = "DELETE FROM $table WHERE ID=$id";
            $result = self::dbConnect()->query($sql);
            self::dbConnect()->close();
            return $result;
        } catch (Exception $e) {
            BasicFunctions::createLog("Login adat törlése sikertelen! Hiba: " . $e->getMessage());
        }
    }
}

class FajlMuveletek
{
    // LOG adatok exportálása text fájlba (bemeneti adatok megadásával)
    public static function exportLogToTXT($text)
    {
        $fajl = "./Logs/" . date("Y_m_d") . ".txt";

        if (!is_file($fajl)) {
            touch($fajl) or die("<h2>Nem hozható létre a fájl!</h2>");
        }

        $fa = fopen($fajl, 'a') or die("<h1>Nem nyitható meg a fájl</h1>");

        fwrite($fa, $text . "\n");
        fclose($fa);
    }

    // SQL adatok exportálása text fájlba (bemeneti adatok megadásával)
    public static function exportToTXTinput($adat, $fajlNeve)
    {
        if ($adat->num_rows > 0) {

            $fajl = "Logs/" . $fajlNeve . ".txt";

            if (!is_file($fajl)) {
                touch($fajl) or die("<h2>Nem hozható létre a fájl!</h2>");
            }

            $fa = fopen($fajl, 'a') or die("<h1>Nem nyitható meg a fájl</h1>");

            foreach ($adat as $egyadat) {
                (int)$seged = 0;
                foreach ($egyadat as $kulcs => $row) {
                    if ($seged < 4) {
                        fwrite($fa, $row . "\t");
                        ++$seged;
                    }
                }
                fwrite($fa, "\n");
            }
            fclose($fa);
        }
    }

    // SQL adatok exportálása CSV fájlba
    public static function exportToCSV($adat, $fajlNeve)
    {
        if ($adat->num_rows > 0) {

            $fajl = "Export/" . $fajlNeve . " " . date("Y.m.d H-i-s") . ".csv";

            if (!is_file($fajl)) {
                touch($fajl) or die("<h2>Nem hozható létre a fájl!</h2>");
            }

            $fa = fopen($fajl, 'w') or die("<h1>Nem nyitható meg a fájl</h1>");

            fwrite($fa, "ID;UserID;IP;LoginDT\n");
            while ($row = $adat->fetch_assoc()) {
                fwrite($fa, $row["ID"] . ";" . $row["UserID"] . ";" . $row["IP"] . ";" . $row["LoginDT"] . "\n");
            }
            fclose($fa);
        }
    }

    // SQL adatok exportálása xml fájlba
    public static function exportToXML($adat, $fajlNeve)
    {
        try {
            if ($adat->num_rows > 0) {
                $adatTomb[] = array();
                (int)$szamlalo = 0;
                $fajl = "Export/" . $fajlNeve . " " . date("Y.m.d H-i-s") . ".xml";
                $doc = new DOMDocument();
                $doc->formatOutput = true;

                $r = $doc->createElement("Bejelentkezesek");
                $doc->appendChild($r);

                while ($row = $adat->fetch_assoc()) {
                    foreach ($row as $ertek) {
                        switch ($szamlalo) {
                            case 0:
                                $idV = $ertek;
                                break;
                            case 1:
                                $userIDV = $ertek;
                                break;
                            case 2:
                                $ipV = $ertek;
                                break;
                            case 3:
                                $loginDtV = $ertek;
                                break;
                        }
                        ++$szamlalo;
                    }
                    $adatTomb[] = array(
                        'id' => $idV,
                        'userID' => $userIDV,
                        'ip' => $ipV,
                        'loginDate' => $loginDtV
                    );
                }

                foreach ($adatTomb as $userX) {
                    $b = $doc->createElement("User");

                    $idX = $doc->CreateElement("ID");
                    $idX->appendChild($doc->createTextNode($userX['id']));
                    $b->appendChild($idX);

                    $userIDX = $doc->CreateElement("UserLogin");
                    $userIDX->appendChild($doc->createTextNode($userX['userID']));
                    $b->appendChild($userIDX);

                    $ipX = $doc->CreateElement("IP");
                    $ipX->appendChild($doc->createTextNode($userX['ip']));
                    $b->appendChild($ipX);

                    $loginDateX = $doc->CreateElement("LoginDate");
                    $loginDateX->appendChild($doc->createTextNode($userX['loginDate']));
                    $b->appendChild($loginDateX);

                    $r->appendChild($b);
                }
                echo $doc->saveXML();
                $doc->save($fajl);
            }
        } catch (Exception $e) {
            BasicFunctions::createLog($e->getMessage());
        }
    }
}
