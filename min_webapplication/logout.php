<?php
include "coreFunctions.php"
?>

<head>
    <meta charset="iso 8859-2">
    <meta name="Krutilla Zsolt" content="Web programozás">
    <title>Kijelentkezés</title>
    <link href="StyleSheetZsolti.css" rel="stylesheet" />
</head>

<header>

    <?php
    SessionFunctions::sessionDelete();
    print("Sikeres kijelentkezés!");
    header("Refresh: 2; URL='index.php'");

    ?>
</header>

<body>
    <h2 style="margin: 10px;">Az oldal 2 másodperc múlva átirányít...</h2>

    <body>