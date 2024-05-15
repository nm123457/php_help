<?php

include 'coreFunctions.php';

if (SessionFunctions::getUserLogin() == null)
    header("location: login.php");
else {
    if (SessionFunctions::GetAccess() != "admin")
        header("location: index.php");
}

?>

<html>
<head>
    <meta charset="iso 8859-2">
    <meta name="Krutilla Zsolt" content="DUE MA">
    <title>Vizsgaeredmények</title>
    <link href="StyleSheetZsolti.css" rel="stylesheet" />
</head>


<body>
    <header>Törlés</header>
    <?php
     SQLfunctions::deleteUserLogin($_GET['ID']);
     header("location: admin/felhasznalok.php")
     ?>

</body>

<p><button onclick="document.location='./index.php'">Vissza</button></p>

</html>