<?php

namespace App\Models\Site;

use App\Models\Model;

class Products extends Model{

    protected $table = 'products';

    public function amountProducts(){
        $sql = "select sum(price) as amount from {$this->table}";
        $find = $this->connection->prepare($sql);
        $find->execute();
        return $find->fetch();
    }

}