<?php
class Database{
        private static $host = 'db';
        private static $database = 'crud';
        private static $username = 'root';
        private static $password = "password";
        private static $user_mail = NULL;
        private static $user_id = NULL;
        private static $conn = NULL;


        // public static function connect() {
        //     global $host, $database, $username, $password; 
        //     $conn = null;   
        //     try {
        //         $conn = new PDO("mysql:host=" . $host . ";dbname=" . $database, $username, $password);
        //         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //     }catch (PDOException $e){
        //         echo "Connection error: ". $e->getMessage();
        //     }
        //     return $conn;
        // }

        public static function getConnection() {
            if (self::$conn === null) {
                try {
                    self::$conn = new PDO(
                        "mysql:host=" . self::$host . ";dbname=" . self::$database,
                        self::$username,
                        self::$password
                    );
                    self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("Connection error: " . $e->getMessage());
                }
            }
            return self::$conn; 
        }
}
    ?>