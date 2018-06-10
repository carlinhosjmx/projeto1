<?php

namespace App\Models\Site;
use App\Models\Model;

class Members extends Model{
    protected $table = 'members';

    public function create($user,$paypalId,$status){
        $query = "insert into {$this->table}(user,paypal_id,status) value(?,?,?)";
        $insert = $this->connection->prepare($query);
        $insert->bindValue(1,$user);
        $insert->bindValue(2,$paypalId);
        $insert->bindValue(3,$status);
        $insert->execute();
        return $this->connection->lastInsertId();
    }

    public function isMember($user){
        $query = "select * from members where user = ? and status = 1";
        $member = $this->connection->prepare($query);
        $member->bindValue(1,$user);
        $member->execute();
        return ($member->rowCount() == 1) ? true : false;
    }
}