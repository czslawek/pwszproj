<?php
include('config.php');

class DB
{
    private static $dbName = DBNAME;
    private static $dbHost = DBHOST;
    private static $dbUsername = DBUSERNAME;
    private static $dbUserPassword = DBUSERPASS;

    private static $conn  = null;

    public function __construct() {
        die('jakis blad z polaczeniem');
    }

    public static function connect()
    {
        if ( null == self::$conn )
        {
            try
            {
                self::$conn =  new PDO( "pgsql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$conn;
    }

    public static function disconnect()
    {
        self::$conn = null;
    }
}
?>