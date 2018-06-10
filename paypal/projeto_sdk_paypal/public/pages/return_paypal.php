<?php

require '../../config.php';

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use App\Models\Site\Products;


$payerId = filter_input(INPUT_GET,'PayerID',FILTER_SANITIZE_STRING);
$paymentId = filter_input(INPUT_GET,'paymentId',FILTER_SANITIZE_STRING);

if(isset($payerId)){

    $product = new Products;
    $products = $product->all();

    $taxa = 10;
    $shipping = 20;
    $subtotal = 0;

    $i = 0;
    foreach($products as $prod){
        $subtotal+=$prod->price;
        $i++;
    }

    $payment = Payment::get($paymentId, $api->api);

    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    $details = new Details();
    $details->setShipping($shipping);
    $details->setTax($taxa);
    $details->setSubtotal($subtotal);

    $amount = new Amount();
    $amount->setCurrency('BRL');
    $amount->setTotal($subtotal+$taxa+$shipping);
    $amount->setDetails($details);

    $transaction = new Transaction();
    $transaction->setAmount($amount);

    $execution->addTransaction($transaction);

    try{
        $result = $payment->execute($execution,$api->api);
        if($result->state == 'approved'){
            // faz alguma coisa
        }
    }catch(PayPal\Exception\PayPalConnectionException $e){
        var_dump($e->getData());
    }

}