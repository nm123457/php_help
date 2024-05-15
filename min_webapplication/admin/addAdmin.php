<?php
include '../coreFunctions.php';

?>

<html>

<head>
    <meta charset="iso 8859-2">
    <meta name="Krutilla Zsolt" content="Web programozás">
    <title>Admin felhasználó hozzáadása</title>
    <link href="../StyleSheetZsolti.css" rel="stylesheet" />
</head>



<body>
    <header>Admin felhasználó hozzáadása</header>
    <?php
    SQLfunctions::adminUserCreate();
    header("Refresh: 2; URL='../index.php'");
    ?>

</body>

<p><button onclick="document.location='../index.php'">Vissza</button></p>

</html>