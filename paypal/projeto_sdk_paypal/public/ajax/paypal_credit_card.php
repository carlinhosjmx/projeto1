<?php
require '../../config.php';

use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;

use App\Classes\Login;
use App\Models\Site\Member;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $login = new Login();

    if(!$login->isLoggedIn()){
        echo json_encode('notLoggedIn');
        die();
    }

    $name = filter_input(INPUT_POST, 'name',FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'last_name',FILTER_SANITIZE_STRING);
    $typeCard = filter_input(INPUT_POST, 'type_card',FILTER_SANITIZE_STRING);
    $numberCard = filter_input(INPUT_POST, 'number_card',FILTER_SANITIZE_STRING);
    $expireYear = filter_input(INPUT_POST, 'expire_year',FILTER_SANITIZE_STRING);
    $expireMonth = filter_input(INPUT_POST, 'expire_month',FILTER_SANITIZE_STRING);
    $cvv = filter_input(INPUT_POST, 'cvv',FILTER_SANITIZE_STRING);

    $card = new CreditCard();
    $card->setType($typeCard);
    $card->setNumber($numberCard);
    $card->setExpireMonth($expireMonth);
    $card->setExpireYear($expireYear);
    $card->setFirstName($name);
    $card->setLastName($lastName);
    $card->setCvv2($cvv);

    $fundingInstrument = new FundingInstrument();
    $fundingInstrument->setCreditCard($card);

    $payer = new Payer();
    $payer->setPaymentMethod('credit_card');
    $payer->setFundingInstruments([$fundingInstrument]);

    $details = new Details();
    $details->setShipping(10);
    $details->setTax(10);
    $details->setSubtotal(30);

    $amount = new Amount();
    $amount->setCurrency('USD');
    $amount->setTotal(50);
    $amount->setDetails($details);

    $transaction = new Transaction();
    $transaction->setAmount($amount);
    $transaction->setDescription('Pagando com o cartão de crédito');

    $payment = new Payment();
    $payment->setIntent('sale');
    $payment->setPayer($payer);
    $payment->setTransactions([$transaction]);

    try{
        $payment->create($api->api);
        $member = new Member;

        if($payment->getState() == 'approved'){
            $member->create($_SESSION['id'],$payment->getId(),1);
            echo json_encode('approved');
            die();
        }

         if($payment->getState() == 'failed'){
           echo json_encode('failed');
           die();
        }

    }catch(PayPal\Exception\PayPalConnectionException $e){
        var_dump($e->getData());
    }
}