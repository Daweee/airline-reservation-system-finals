<?php

class Database
{
   
    public function getConn()
    {
        $db_host = "localhost";
        $db_name = "airline_reservation";
        $db_user = "mandawe_tejana";
        $db_pass = ".p/PRY6xup*XkF9c";

        $dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

        try {

            $db = new PDO($dsn, $db_user, $db_pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;

        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
