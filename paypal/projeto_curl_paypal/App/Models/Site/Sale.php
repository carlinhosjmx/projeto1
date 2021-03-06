<?php

namespace App\Models\Site;
use App\Models\Model;

class Sale extends Model{

    protected $table = 'sales';

    public function create($paypalId,$status,$user){
        $query = "insert into {$this->table}(paypal_id,status,user) value(?,?,?)";
        $insert = $this->connection->prepare($query);
        $insert->bindValue(1,$paypalId);
        $insert->bindValue(2,$status);
        $insert->bindValue(3,$user);
        $insert->execute();
        return $this->connection->lastInsertId();
    }

    public function update($paypalId,$status){
        $query = "update {$this->table} set status = 1 where paypal_id = ?";
        $insert = $this->connection->prepare($query);
        $insert->bindValue(1,$paypalId);
        $insert->execute();
        return $this->connection->lastInsertId();
    }


}
