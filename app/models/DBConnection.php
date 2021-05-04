<?php


namespace app\models;


use PDO;
use PDOException;

class DBConnection
{
    protected $dsn;
    protected $user;
    protected $password;
    protected $options;
    
    public function __construct()
    {
        $this->dsn = 'mysql:host=127.0.0.1;dbname=my_mvc';
        $this->user = 'phpmyadmin';
        $this->password = '1';
        $this->options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
    }
    
    public function connect()
    {
        try {
            return new PDO($this->dsn, $this->user, $this->password, $this->options);
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            exit;
        }
    }
}