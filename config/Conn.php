<?php
class Conn
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $host = "localhost"; // "192.168.8.103";
        $username = "quintaf";
        $password = "Qu!nta";

        $dbname = "ticketwo";

        try {
            $this->conn = new mysqli($host, $username, $password, $dbname);
        } catch (mysqli_sql_exception $e) {
            echo "<h1>Error while connecting to MySQL</h1>";
            die("Error while connecting to MySQL" . $e->getMessage());
        }
    }

    public static function getInstance(): Conn
    {
        if (self::$instance === null) {
            self::$instance = new Conn();
        }

        return self::$instance;
    }

    public function getConn(): mixed
    {
        return $this->conn;
    }
}
