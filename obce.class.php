<?php


class obce
{
    public $conn;
    /** Konstruktor se připojí k databázi ASW*/
    public function __construct($host, $port, $dbname, $user, $pass)
    {
        $dsn = "mysql:host=$host;dbname=$dbname;port=$port";
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try
        {
            $this->conn = new PDO($dsn, $user, $pass, $options);
        }
        catch(PDOException $e)
        {
            echo "Nelze se připojit k MySQL: ";  echo $e->getMessage();
        }

    }
    /**Metoda vrací kraje z DB
     * @param int řazení krajů: 1 = dle kódu; 2 = dle názvu - výchozí
     * @return pole objektů kraj
     * @return array
     */
    public function vratKraje($serad = 2) // Když nechci aby byl parametr povinný, proto napíšu čemu se má rovnat, když ten parametr chybí
    {
        try {
            $dotaz = $this->conn->prepare("SELECT kraj_kod as kod, nazev FROM LOC_kraj order by :serad ASC;");
            $dotaz->bindParam(':serad', $serad, PDO::PARAM_INT);  //filtruje a pustí jen číslo, ochrana aby se tam nenapsal nějakej příkaz
            $dotaz->execute();
            return $dotaz->fetchAll(PDO::FETCH_OBJ); // pole objektů
        } catch (PDOException $e)
        {
            echo "Chyba čtení tabulky kraj: ";
            echo $e->getMessage();
        }
    }
    public function vratObce($kraj_kod, $serad = 2)
    {
        try {
            $dotaz = $this->conn->prepare("SELECT LOC_obec.obec_kod AS kod, LOC_obec.nazev FROM `LOC_obec` JOIN LOC_okres ON LOC_obec.okres_kod = LOC_okres.okres_kod WHERE LOC_okres.kraj_kod = :kraj_kod order by :serad ASC;");
            $dotaz->bindParam(':kraj_kod', $kraj_kod, PDO::PARAM_INT);
            $dotaz->bindParam(':serad', $serad, PDO::PARAM_INT);
            $dotaz->execute();
            return $dotaz->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e)
        {
            echo "Chyba čtení tabulky obce: ";
            echo $e->getMessage();
        }
    }
    public function getCountyName($id_county)
    {
        try {
            $dotaz = $this->conn->prepare("SELECT nazev FROM `LOC_kraj` WHERE LOC_kraj.kraj_kod = :kraj_kod;");
            $dotaz->bindParam(':kraj_kod', $id_county, PDO::PARAM_INT);
            $dotaz->execute();
            $data=$dotaz->fetch(PDO::FETCH_OBJ);
            if($dotaz->rowCount() == 0)
            {
                return "";
            }
            else
            {
                //var_dump($data);
                //$data = json_decode(json_encode($data), true);
                return $data->nazev;
            }
        } catch (PDOException $e)
        {
            echo "Chyba čtení tabulky obce: ";
            echo $e->getMessage();
        }
    }
    public function getCityName($id_city)
    {
        try {
            $dotaz = $this->conn->prepare("SELECT nazev FROM `LOC_obec` WHERE LOC_obec.obec_kod = :obec_kod;");
            $dotaz->bindParam(':obec_kod', $id_city, PDO::PARAM_INT);
            $dotaz->execute();
            $data=$dotaz->fetch(PDO::FETCH_OBJ);
            if($dotaz->rowCount() == 0)
            {
                return "";
            }
            else
            {
                //var_dump($data);
                //$data = json_decode(json_encode($data), true);
                return $data->nazev;
            }
        } catch (PDOException $e)
        {
            echo "Chyba čtení tabulky obce: ";
            echo $e->getMessage();
        }
    }
    public function getStreetName($id_street)
    {
        try {
            $dotaz = $this->conn->prepare("SELECT nazev FROM `LOC_ulice` WHERE LOC_ulice.ulice_kod = :ulice_kod;");
            $dotaz->bindParam(':ulice_kod', $id_street, PDO::PARAM_INT);
            $dotaz->execute();
            $data=$dotaz->fetch(PDO::FETCH_OBJ);
            if($dotaz->rowCount() == 0)
            {
                return "";
            }
            else
            {
                //var_dump($data);
                //$data = json_decode(json_encode($data), true);
                return $data->nazev;
            }
        } catch (PDOException $e)
        {
            echo "Chyba čtení tabulky obce: ";
            echo $e->getMessage();
        }
    }
    public function vratUlice($obec_kod, $serad = 2)
    {
        try {
            //$dotaz = $this->conn->prepare("SELECT LOC_ulice.ulice_kod AS kod, LOC_ulice.nazev FROM `LOC_ulice` JOIN LOC_obec ON LOC_ulice.obec_kod = LOC_obec.obec_kod WHERE LOC_ulice.obec_kod = :obec_kod order by :serad ASC;");
            $dotaz = $this->conn->prepare("SELECT LOC_ulice.ulice_kod AS kod, LOC_ulice.nazev FROM `LOC_ulice` order by :serad ASC limit 100;");
            //$dotaz->bindParam(':obec_kod', $obec_kod, PDO::PARAM_INT);
            $dotaz->bindParam(':serad', $serad, PDO::PARAM_INT);
            $dotaz->execute();
            return $dotaz->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e)
        {
            echo "Chyba čtení tabulky ulice: ";
            echo $e->getMessage();
        }
    }

}