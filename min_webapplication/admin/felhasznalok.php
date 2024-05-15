<?php

include "../coreFunctions.php";

if (SessionFunctions::getUserLogin() == null)
    header("location: ../login.php");
else {
    if (SessionFunctions::getAccess() != "admin")
        header("location: ../index.php");
}

?>

<html>

<head>
    <meta charset="iso 8859-2">
    <meta name="Krutilla Zsolt" content="Web programozás">
    <title>Bejelentkezések</title>
    <link href="../StyleSheetZsolti.css" rel="stylesheet" />
</head>

<body>
    <header>Bejelentkezések</header>
    <?php

    SQLfunctions::getPagingTablazat(5);

    ?>

</body>

<p><button onclick="document.location='../index.php'">Vissza</button></p>

</html>