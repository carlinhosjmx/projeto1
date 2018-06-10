<?php

namespace App\Classes\Paypal;

use App\Classes\Paypal\Paypal;

// 1 - vai criar a cobranca - gerar uma id
// 2 - enviar a cobranca
// 3 - cancela
//
class Invoice extends Paypal{

    public function create($data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/invoicing/invoices");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          "Content-Type:application/json",
          "Authorization: Bearer {$this->token}"
          )
        );
        $retorno_transaction = curl_exec($curl);
        curl_close($curl);
        return json_decode($retorno_transaction);
    }

    public function send($invoiceId){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/invoicing/invoices/{$invoiceId}/send");
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type:application/json",
        "Authorization: Bearer {$this->token}"
        )
      );
      curl_exec($curl);
      curl_close($curl);
   }

   public function getInvoice($invoiceId){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/invoicing/invoices/{$invoiceId}");
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER , true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type:application/json",
        "Authorization: Bearer {$this->token}"
        )
      );
      $retorno_transaction = curl_exec($curl);
      curl_close($curl);
      return json_decode($retorno_transaction);
   }

    public function cancel($invoiceId,$data){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/invoicing/invoices/{$invoiceId}/cancel");
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,true);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($data));
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type:application/json",
        "Authorization: Bearer {$this->token}"
        )
      );
      $retorno_transaction = curl_exec($curl);
      curl_close($curl);
      return json_decode($retorno_transaction);
   }

}