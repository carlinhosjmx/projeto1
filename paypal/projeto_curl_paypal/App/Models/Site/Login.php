<?php

namespace App\Models\Site;
use App\Models\Site\User;

class Login{

    public function login(User $model,Array $data){
        $query = "select * from {$model->table} where email=? and password=?";
        $login = $model->connection->prepare($query);
        $login->bindValue(1,$data['email']);
        $login->bindValue(2,md5($data['password']));
        $login->execute();
        return $login->fetch();
    }

}