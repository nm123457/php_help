<?php

include "coreFunctions.php";

if (SessionFunctions::getUserLogin() == null)
    header("location: login.php");
?>

<html>

<head>
    <meta charset="iso 8859-2">
    <meta name="Krutilla Zsolt" content="Web programozás">
    <title>Letöltések</title>
    <link href="StyleSheetZsolti.css" rel="stylesheet" />
</head>

<body>
    <nav>
        <button onclick="document.location='index.php'">Vissza</button>
    </nav>

    <header>
        Saját fájlok letöltése<br>&#128522
    </header>

    <div>
        <h1>
            <p><a href="download.php?fajl=Web_programozas.pdf">Első fájl</a></p>
            <p><a href="download.php?fajl=valamilyenFajl.zip">Második fájl</a></p>
        </h1>
    </div>

</body>

</html>