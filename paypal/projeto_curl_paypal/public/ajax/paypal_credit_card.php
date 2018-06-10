<?php

require '../../config.php';
use App\Classes\Paypal\Payment;
use App\Classes\Login;
use App\Models\Site\Members;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $login = new Login();
  if(!$login->isLoggedIn()){
    echo json_encode('notLoggenIn');
    die();
  }

$data = [
    "intent"=>"sale",
    "payer"=>[
        "payment_method"=>"credit_card",
        "funding_instruments"=>array([
          "credit_card"=>[
              "number"=>$_POST['number_card'],
              "type"=>$_POST['type_card'],
              "expire_month"=>$_POST['expire_month'],
              "expire_year"=>$_POST['expire_year'],
              "cvv2"=>$_POST['cvv'],
              "first_name"=>$_POST['name'],
              "last_name"=>$_POST['last_name'],
              "billing_address"=>[
                  "line1"=>"Rua Joao Belquior Marques Goulart, 64",
                  "city"=>"Araraquara",
                  "state"=>"SP",
                  "postal_code"=>"14811260",
                  "country_code"=>"BR"
              ]
          ]
          ])
        ],
         "transactions"=>array([
           "amount"=>[
             "total"=>"515.00",
             "currency"=>"USD",
             "details"=>[
                "subtotal"=>"500.00",
                "shipping" => "15.00",
                "tax" => "0.00"
              ]
         ],
         "description" => "Pagamento do curso php sem medo"
    ])
];

$payment = new Payment;
$retorno = $payment->payment($data);

if($retorno->state == 'approved'){
    // enviar email para o cliente
    $members = new Members;
    $members->create($_SESSION['id'],$retorno->id,1);
    echo json_encode('approved');
}

if($retorno->state == 'failed'){
    // enviar email para o cliente
    $members = new Members;
    $members->create($_SESSION['id'],$retorno->id,2);
}

if($retorno->state == 'created'){
    // enviar email para o cliente
}

}