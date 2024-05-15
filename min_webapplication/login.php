<?php
include "coreFunctions.php";
?>

<html>

<head>
    <meta charset="iso 8859-2">
    <meta name="Krutilla Zsolt" content="Web programozás">
    <title>Bejelentkezés</title>
    <link href="StyleSheetZsolti.css" rel="stylesheet" />

</head>

<body>
    <header>Bejelentkezés</header>
    <form action="" method="POST">
        <div>
            <h2>Felhasználónév:</h2>
            <input type='text' name='felhasznalo'>
            <br>
        </div>
        <div>
            <h2>Jelszó:</h2>
            <input type='password' name='jelszo'>
            <br>
            <input type='submit' name='OK' value='Küldés' class='sajatButton'>
        </div>
    </form>
    <?php
    if (isset($_POST["felhasznalo"]) && isset($_POST["jelszo"])) {
        SQLfunctions::login($_POST["felhasznalo"], $_POST["jelszo"]);
    }
    ?>
</body>
<p><button onclick="document.location='index.php'">Vissza</button></p>

</html>