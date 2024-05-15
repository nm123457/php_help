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
    <title>Új felhasználó</title>
    <link href="../StyleSheetZsolti.css" rel="stylesheet" />
</head>

<body>
    <header>Új felhasználó</header>
    <form action="" method="POST">
        <div>
            <h2>Név:
                <input type='text' name='nev' class='sajatTextBox'>
            </h2>
            <h2>Login:
                <input type='text' name='felhasznalo' class='sajatTextBox'>
            </h2>
            <h2>Jelszó:
                <input type='password' name='jelszo' class='sajatTextBox'>
            </h2>
            <h2><label for="acc">Szerepkör:</label>
                <select name="acc" id="acc" class='sajatCombobox'>
                    <option value="user">Általános</option>
                    <option value="admin">Rendszergazda</option>
                    <option value="due">DUE</option>
                    <option value="vip">VIP</option>
                </select>
            </h2>
            <br>
            <input type='submit' name='OK' value='Küldés' class='sajatButton'>
        </div>
    </form>
    <?php

    if (isset($_POST["felhasznalo"]) && isset($_POST["jelszo"])) {
        SQLfunctions::addUser($_POST["felhasznalo"], $_POST["nev"], $_POST["jelszo"], $_POST["acc"]);
        header("Refresh: 2; URL='../index.php'");
    }
    ?>
</body>
<p><button onclick="document.location='../index.php'">Vissza</button></p>

</html>