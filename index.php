<?php
require_once "obce.class.php";
require_once "credentials.php";
global $county;
$county = new obce($host, $port, $dbname, $user, $pass); // $county = Obec_OBJ (je to objekt), new obce je třída
//$id_city = $_POST["id_city"];
//$id_street = $_POST["id_street"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Locator</title>


    <style>

        body {
            font-size:40px;
        }
        h1 {
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
if (isset ($_POST["id_county"])) {
    $id_county = $_POST["id_county"];
    echo "Selected county: ".$county->getCountyName($id_county).", ID:".$id_county;
    if (isset ($_POST["id_city"])) {
        $id_city = $_POST["id_city"];
        echo "Selected city: ".$county->getCityName($id_city).", ID:".$id_city;
        if (isset ($_POST["id_street"])) {
            $id_street = $_POST["id_street"];
            echo "Selected Street: ".$county->getStreetName($id_street).", ID:".$id_street;
        }
        else {

?>
<h1>Step 3: Select a street</h1>
<form method="POST">
<input type="hidden" name="id_city" value="<?php echo $id_city?>">
<input type="hidden" name="id_county" value="<?php echo $id_county?>">
<select name="id_street">
<?php

    $streets = $county->vratUlice($id_city);
    foreach ($streets as $street)
    {
        echo '<option value="';
        echo $street->kod;
        echo '">';
        echo $street->nazev;
        echo '</option>';
        echo "\n";

    }

    //echo $county->vratKraje()[0]->nazev;
    //var_dump($county->vratKraje());
?>
</select>
<input name="street" type="submit" value="Next">
</form>
<?php
    }
} else {
?>
<h1>Step 2: Select a city</h1>
<form method="POST">
<input type="hidden" name="id_county" value="<?php echo $id_county?>">
<select name="id_city">
<?php

    $cities = $county->vratObce($id_county);
    foreach ($cities as $city)
    {
        echo '<option value="';
        echo $city->kod;
        echo '">';
        echo $city->nazev;
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
}


else {

?>

<h1>Step 1: Select a county</h1>
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
<input name="county" type="submit" value="Next">
</form>
<?php
}
?>



</body>
</html>
