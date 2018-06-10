<?php

require '../../config.php';

use PayPal\Api\Address;
use PayPal\Api\BillingInfo;
use PayPal\Api\Cost;
use PayPal\Api\Currency;
use PayPal\Api\Invoice;
use PayPal\Api\InvoiceAddress;
use PayPal\Api\InvoiceItem;
use PayPal\Api\MerchantInfo;
use PayPal\Api\PaymentTerm;
use PayPal\Api\Phone;
use PayPal\Api\ShippingInfo;
use PayPal\Api\Tax;

use App\Classes\Login;
use App\Models\Site\User;
use App\Models\Site\Invoice as InvoiceModel;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $login = new Login();
    if(!$login->isLoggedIn()){
        echo json_encode('notLogged');
        die();
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING);

    $user = new User;
    $userEncontrado = $user->find('email',$email);

    if(!$userEncontrado){
        echo json_encode('notFoundUser');
        die();
    }

    $invoice = new Invoice;
    $invoice->setMerchantInfo(new MerchantInfo())
            ->setBillingInfo(array(new BillingInfo()))
            ->setNote('Enviando cobrança para uma empresa')
            ->setPaymentTerm(new PaymentTerm())
            ->setShippingInfo(new ShippingInfo());

   $invoice->getMerchantInfo()
           ->setEmail('contato@asolucoesweb.com.br')
           ->setFirstName('Alexandre')
           ->setLastName('Cardoso')
           ->setbusinessName('asolucoesweb')
           ->setPhone(new Phone())
           ->setAddress(new Address());

    $invoice->getMerchantInfo()
            ->getPhone()
            ->setCountryCode('055')
            ->setNationalNumber('16992467199');

    $invoice->getMerchantInfo()
            ->getAddress()
            ->setLine1('Rua empresa')
            ->setCity('Araraquara')
            ->setState('SP')
            ->setPostalCode('14811260')
            ->setCountryCode('BR');

    $billing = $invoice->getBillingInfo();

    $billing[0]->setEmail($email)
            ->setBusinessName("Empresa cobrada")
            ->setAdditionalInfo("Esta é uma cobrança para a empresa cobrada")
            ->setAddress(new InvoiceAddress())
            ->getAddress()
            ->setLine1("ebdereço empresa cobrada")
            ->setCity("Rio de Janeiro")
            ->setState("RJ")
            ->setPostalCode("14811459")
            ->setCountryCode("BR");

    $items = array();
    $items[0] = new InvoiceItem();
    $items[0]->setName('Cobrança de alguma coisa')
             ->setQuantity(1)
             ->setUnitPrice(new Currency());

    $items[0]->getUnitPrice()
             ->setCurrency('BRL')
             ->setValue($valor);

    $invoice->setItems($items);

    $invoice->getPaymentTerm()
            ->setTermType('NET_45');

   $invoice->getShippingInfo()
            ->setFirstName('Joana')
            ->setLastName('Pereira')
            ->setbusinessName('Minha empresa')
            ->setPhone(new Phone())
            ->setAddress(new InvoiceAddress());

   $invoice->getShippingInfo()
            ->getPhone()
            ->setCountryCode('055')
            ->setNationalNumber('16992468776');

    $invoice->getShippingInfo()->getAddress()
            ->setLine1('Endereço de entrega')
            ->setCity('Rio de Janeiro')
            ->setState('RJ')
            ->setPostalCode('14822298')
            ->setCountryCode('BR');

    $invoice->setLogoUrl('https://www.paypalobjects.com/webstatic/i/logo/rebrand/ppcom.svg');

    try{
        $create = $invoice->create($api->api);
        $invoice->send($api->api);

        $getInvoice = Invoice::get($invoice->getId(), $api->api);

        $invoiceModel = new InvoiceModel;
        if($getInvoice->status == 'SENT'){
            $invoiceModel->create($userEncontrado->id, $invoice->getId(), $getInvoice->status, $valor);
            echo json_encode('sent');
            die();
        }

        if($getInvoice->status == 'FAILED'){
            $invoiceModel->create($userEncontrado->id, $invoice->getId(), $getInvoice->status, $valor);
            echo json_encode('failed');
            die();
        }
    }catch(PayPal\Exception\PayPalConnectionException $e){
        var_dump($e->getData());
    }

}