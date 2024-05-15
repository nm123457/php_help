<?php

include "coreFunctions.php";

if (SessionFunctions::getUserLogin() == null)
    header("location: login.php");
?>

<html>

<head>
    <meta charset="iso 8859-2">
    <meta name="Krutilla Zsolt" content="Web programozás">
    <title>Exportálás</title>
    <link href="StyleSheetZsolti.css" rel="stylesheet" />
</head>

<body>
    <nav>
        <button onclick="document.location='index.php'">Vissza</button>
    </nav>

    <header>
        Listák exportálása
    </header>

    <div>
        <h1>
            <?php
            SQLfunctions::getPagingTablazat(0, true);
            BasicFunctions::createLog("Sikeres fájl exportálás! (Felhasználó: " . SessionFunctions::getUserFullName() . ")");
            ?>
        </h1>
        <h2>Exportálás kész!</h2>
    </div>
    <?php
    header("Refresh: 2; URL='index.php'");
    ?>
</body>

</html>