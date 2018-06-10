<?php

namespace App\Models\Site;

use App\Models\Model;

class Invoice extends Model{

    protected $table = 'invoice';

    public function create($user,$invoiceId,$status,$templateId,$price){
        $sql = "insert into $this->table(user,invoice_id,status,template_id,price) values(?,?,?,?,?)";
        $insert = $this->connection->prepare($sql);
        $insert->bindValue(1,$user);
        $insert->bindValue(2,$invoiceId);
        $insert->bindValue(3,$status);
        $insert->bindValue(4,$templateId);
        $insert->bindValue(5,$price);
        $insert->execute();
    }

    public function update($id,$status){
        $sql = "update {$this->table} set status = ? where id = ?";
        $update = $this->connection->prepare($sql);
        $update->bindValue(1,$status);
        $update->bindValue(2,$id);
        $update->execute();
    }

    public function invoices(){
        $sql = "select *, invoice.id as invoiceId from {$this->table} inner join users on users.id = invoice.user";
        $list = $this->connection->prepare($sql);
        $list->execute();
        return $list->fetchAll();
    }

}