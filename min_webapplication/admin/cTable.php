<?php
include '../coreFunctions.php';

if (SessionFunctions::getUserLogin() == null)
    header("location: ../login.php");
else {
    if (SessionFunctions::getAccess() != "admin")
        header("location: ../index.php");
}

$kapcsolat = SQLfunctions::dbConnect();

// LOG tábla létrehozása
$sqlQuery = "CREATE TABLE Logs (
    ID int NOT NULL AUTO_INCREMENT,
    Login varchar(50) NOT NULL,
    Message text,
    LogTime datetime NOT NULL,
    PRIMARY KEY (ID)
    );";

$result = $kapcsolat->query($sql);

if ($result)
    print("<div><h2>Sikeres tábla létrehozás!</div></h2>");
else
    print("<div><h2>Tábla létrehozása sikertelen!</div></h2>");

// Create IP table
$sql = "CREATE TABLE userIP(
    ID INT NOT NULL AUTO_INCREMENT,
    UserID VARCHAR(50),
    IP VARCHAR(255) NOT NULL,
    LoginDT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID))";

$result = $kapcsolat->query($sql);

if ($result)
    print("<div><h2>Sikeres tábla létrehozás!</div></h2>");
else
    print("<div><h2>Tábla létrehozása sikertelen!</div></h2>");

// Create user
$sql = "CREATE TABLE userLogin(
        UserID VARCHAR(50) NOT NULL,
        Nev VARCHAR(50) NOT NULL,
        PassW TEXT,
        Access VARCHAR(50),
        CreatedDT TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (UserID))";

$result = $kapcsolat->query($sql);

if ($result)
    print("<div><h2>Sikeres tábla létrehozás!</div></h2>");
else
    print("<div><h2>Tábla létrehozása sikertelen!</div></h2>");
$kapcsolat->close();
