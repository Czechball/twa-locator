<?php
require_once "obce.class.php";
require_once "credentials.php";
global $;
$county = new obce($host, $port, $dbname, $user, $pass); // $county = Obec_OBJ (je to objekt), new obce je třída
$id_county = $_POST["id_county"];
$id_city = $_POST["id_city"];
$id_street = $_PORST["id_street"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Locator</title>


    <style>

        body {
            -webkit-animation: colorchange 20s infinite;
            animation: colorchange 20s infinite;
            font-size:40px;
        }
        h1 {
            -webkit-animation: colorchange 20s infinite;
            animation: colorchange 20s infinite;
            font-family:georgia,garamond,serif;

        }
        @-webkit-keyframes colorchange {
            0%  {background: #a8ffb3;}
            25%  {background: #8acfd3;}
            50%  {background: #5b81c1;}
            75%  {background: #d581dc;}
            100% {background: #e3989c;}
    </style>

</head>
<body>
<?php
if ($id_county == "") {
    echo "<h1>Step 1: Select a county</h1>"
?>


<form method="POST">
<select name="id_county">
<?php

    $kraje = $county->vratKraje();
    foreach ($kraje as $kraj)
    {
        echo '<option value="';
        echo $kraj->kod;
        echo '">';
        echo $kraj->nazev;
        echo '</option>';
        echo "\n";

    }

    //echo $county->vratKraje()[0]->nazev;
    //var_dump($county->vratKraje());
?>
</select>
<input name="city" type="submit" value="Next">
</form>
<?php
}
?>



</body>
</html>
