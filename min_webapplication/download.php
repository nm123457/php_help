<?php

if (isset($_GET['fajl'])) {

    //Read the filename
    $filename = "AAAA1111/" . $_GET['fajl'];

    //Check the file exists or not
    if (file_exists($filename)) {
        //Define header information
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Length: ' . filesize($filename));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($filename);

        //Terminate from the script
        die();
    } else {
?>

        <head>
            <meta charset="iso 8859-2">
            <meta name="Krutilla Zsolt" content="Web programozás">
            <title>Letöltés</title>
            <link href="StyleSheetZsolti.css" rel="stylesheet" />
            <div>
                <h1 class="unsuccessSajat center">Fájl nem létezik!!</h1>
            </div>
        </head>
    <?php
    }
} else {
    ?>

    <head>
        <meta charset="iso 8859-2">
        <meta name="Krutilla Zsolt" content="Web programozás">
        <title>Letöltés</title>
        <link href="StyleSheetZsolti.css" rel="stylesheet" />
        <div>
            <h1 class="unsuccessSajat center">Nincs megadva fájl!</h1>
        </div>
    </head>
<?php

}

header("Refresh: 2; URL='./letoltesek.php'");

?>