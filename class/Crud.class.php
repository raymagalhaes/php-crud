<?php

/**
*
* A class for database operations in a simple way
*
*@author Ray Magalhães <rayfsd@gmail.com>
*@version 0.1
*
*
*/

class Crud
{
    // Instance property for singleton
    private static $Instance;
    // name of database table
    public $Table;
    // table columns to select
    public $Cols;
    // PDO Statement
    private $Sttmt;
    // Data to process (must be array)
    private $Data;
    // Where Clause to find (must be array)
    private $Where;
    //PDO Class
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=testDatabase;charset=utf8mb4", "dbusername", "dbpassword");
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance()
    {
        if (self::$Instance === null) {
            self::$Instance = new self;
        }
        return self::$Instance;
    }

    public function Select($Table, $Cols = "*", $Where = [])
    {
        $this->Table = $Table;
        $this->Cols = $Cols;
        $this->Where = $Where;
        if (is_array($this->Where) && !empty($this->Where)) {
            $Wher = " WHERE ";
            foreach ($this->Where as $key => $value) {
                $Wher .= substr($key, 1) . " = " . $key . " AND ";
            }
            $Wher = substr($Wher, 0, -5);
        } else {
            $Wher = "";
        }
        $this->Sttmt = $this->pdo->prepare("SELECT {$this->Cols} FROM {$this->Table} {$Wher}");
        $this->Sttmt->execute($this->Where);
        return $this->Sttmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Insert($Table, $Data)
    {
    }

    public function Update($Table, $Data, $Params)
    {
    }

    public function Delete($Table, $Params)
    {
    }
}
