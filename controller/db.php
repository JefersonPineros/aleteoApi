<?php 

class DB {
    private static $dbConnection;
    private static $db = "aleteo";
    private static $host = "localhost";
    private static $port = "3306";
    private static $user = "root";
    private static $password = "";

    public static function conectarDB(){
        try{
            if(self::$dbConnection == null){
                // self::$dbConnection = pg_connect("host=".self::$host." port=".self::$port." dbname=".self::$db." user=".self::$user." password=".self::$password);
                self::$dbConnection = 
                new PDO("mysql:dbname=".self::$db.";host=".self::$host.";port=".self::$port.":charset=utf8",self::$user,self::$password);
                self::$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                return self::$dbConnection;
            }
        }catch (Throwable $t){
            return $t->getMessage();
        }
    }
}

?>