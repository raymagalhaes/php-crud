<?php

namespace Ray;

use \PDO;
use \Exception;

/**
*
* A class for database operations in a simple way
*
*@author Ray Magalhães <rayfsd@gmail.com>
*@version 0.1
*
*/

class Crud
{
    // name of database table
    public $Table;
    // table columns to select
    public $Cols;
    // PDO Statement
    private $prest;
    // Data to process (must be array)
    private $Data;
    // Where Clause to find (must be array)
    private $Where;
    //PDO Class
    private $Pdo;
    //returned matrix of data
    public $Return;

    public function __construct()
    {
        try {
            $this->Pdo = new \PDO(
                "mysql:host=localhost;dbname=testDatabase;charset=utf8mb4",
                "dbusername",
                "dbpassword"
            );
            $this->Pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            error_log($e->getMessage());
        }
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

        $this->prest = $this->Pdo->prepare("SELECT {$this->Cols} FROM {$this->Table} {$Wher}");
        $this->prest->execute($this->Where);

        if (!empty($this->prest->errorInfo()[1])) {
            return print_r($this->prest->errorInfo(), true);
        } else {
            return $this->prest->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function Insert($Table, $Data)
    {
        $this->Table = $Table;

        if (!is_array($Data)) {
            throw new CrudException("Invalid Insert Array");
        }
        $Parsed = $this->parseInsertArray($Data);

        $sql = "INSERT INTO {$Table} {$Parsed->vString} VALUES {$Parsed->vGroups}";
        $this->prest = $this->Pdo->prepare($sql);

        try {
            $this->prest->execute($Parsed->execArray);
            return $this->Pdo->lastInsertId();
        } catch (\PDOException $e) {
            error_log(print_r($e, true));
            return false;
        }
    }

    public function Update($Table, $Data, $Params)
    {
    }

    public function Delete($Table, $Params)
    {
    }
    public function parseInsertArray(array $array)
    {
        foreach ($array[0] as $key => $value) {
            @$vString .= $value . " , ";
        }
        $vString = "(".substr($vString, 0, -3).")";

        unset($array[0]);

        foreach ($array as $mkey => $value) {
            foreach ($array[$mkey] as $key => $value) {
                $newArray[] = $value;
                @$vGroup .= "? , ";
            }
            $vGroup = substr($vGroup, 0, -3);
            @$vGroups .= "({$vGroup}) , ";
            unset($vGroup);
            unset($array[$mkey]);
        }

        $vGroups = substr($vGroups, 0, -3);

        return (object)[
          "execArray" => $newArray,
          "vString" => $vString,
          "vGroups" => $vGroups
        ];
    }
}
