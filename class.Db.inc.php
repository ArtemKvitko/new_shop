<?php

class Db {
    private $connection;
    private static $_instance;
    protected $db;

    public static function getInstance() {
        if (!self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct(){
        $this->connection = new PDO('mysql:host=localhost;dbname=myshop;charset=utf8', 'root', '');
    }

    private function __clone(){}

    public function getConnection(){
        return $this->connection;
    }

    public static function userExist($user_email){


        $db = self::getInstance()->getConnection() ;
        $res=$db ->prepare('
        SELECT * FROM users WHERE email="'.$user_email.'" LIMIT 1'
        );

        $res ->execute();
        $result=$res->fetch();
        //echo '<pre>'.var_dump($result).'</pre><p></p>';
        if ($result) {
            $result=(object)$result;
          //  echo '<pre>'.var_dump($result).'</pre>';
        }
        return $result;

    }

}

