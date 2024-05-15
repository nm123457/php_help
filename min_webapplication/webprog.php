<?php

include "coreFunctions.php";

if (SessionFunctions::getUserLogin() == null)
    header("location: login.php");
else if (SessionFunctions::getAccess() != 'admin' && SessionFunctions::getAccess() != 'vip')
    header("location: index.php");
?>

<html>

<head>
    <meta charset="iso 8859-2">
    <meta name="Krutilla Zsolt" content="Web programozás">
    <title>VIP oldal</title>
    <link href="StyleSheetZsolti.css" rel="stylesheet" />
</head>

<body>
    <nav>
        <button onclick="document.location='index.php'">Vissza</button>
    </nav>

    <header>
        Ez egy VIP oldal<br>&#128522
    </header>
</body>

</html>