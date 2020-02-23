<?php


class obce
{
    public $conn;
    /** Konstruktor se připojí k databázi ASW*/
    public function __construct($host, $port, $dbname, $user, $pass)
    {
        $dsn = "mysql:host=localhost;dbname=$dbname;port=3336";
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
            $dotaz = $this->conn->prepare("SELECT kraj_kod as kod, nazev FROM kraj order by :serad ASC;");
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
            $dotaz = $this->conn->prepare("SELECT obec.obec_kod AS kod, obec.nazev FROM `obec` JOIN okres ON obec.okres_kod = okres.okres_kod WHERE okres.kraj_kod = :kraj_kod order by :serad ASC;");
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

    public function vratUlice($obec_kod, $serad = 2)
    {
        try {
            $dotaz = $this->conn->prepare("SELECT ulice.ulice_kod AS kod, ulice.nazev FROM `ulice` JOIN obec ON ulice.obec_kod = obec.obec_kod WHERE ulice.obec_kod = :obec_kod order by :serad ASC;");
            $dotaz->bindParam(':obec_kod', $obec_kod, PDO::PARAM_INT);
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