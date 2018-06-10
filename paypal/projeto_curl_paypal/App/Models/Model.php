<?php

namespace App\Models;
use App\Models\Connection;

class Model{

    public $connection;

    public function __construct(){
        $connection = new Connection;
        $this->connection = $connection->connect();
    }

    public function find($field,$value){
        $sql = "select * from {$this->table} where $field = ?";
        $find = $this->connection->prepare($sql);
        $find->bindValue(1,$value);
        $find->execute();
        return $find->fetch();
    }

    public function all(){
        $sql = "select * from {$this->table}";
        $find = $this->connection->prepare($sql);
        $find->execute();
        return $find->fetchAll();
    }

}