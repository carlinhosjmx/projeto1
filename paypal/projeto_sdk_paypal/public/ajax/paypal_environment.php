
<?php

require '../../config.php';
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

use App\Classes\Login;
use App\Models\Site\Products;
use APp\Models\Site\Sale;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $login = new Login();
    if(!$login->isLoggedIn()){
        echo json_encode('notLoggedIn');
        die();
    }

    $product = new Products;
    $products = $product->all();

    $uniqid = uniqid();
    $taxa = 10;
    $shipping = 20;
    $subtotal = 0;

    $i = 0;
    foreach($products as $prod){
        $items[$i] = new Item();
        $items[$i]->setName($prod->name);
        $items[$i]->setCurrency('BRL');
        $items[$i]->setQuantity(1);
        $items[$i]->setSku($uniqid);
        $items[$i]->setprice($prod->price);
        $subtotal+=$prod->price;
        $i++;
    }

    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $itemsList = new ItemList;
    $itemsList->setItems($items);

    $details = new Details();
    $details->setShipping($shipping);
    $details->setTax($taxa);
    $details->setSubtotal($subtotal);

    $amount = new Amount();
    $amount->setCurrency('BRL');
    $amount->setTotal($subtotal+$taxa+$shipping);
    $amount->setDetails($details);

    $transaction = new Transaction;
    $transaction->setAmount($amount);
    $transaction->setItemList($itemsList);
    $transaction->setDescription('Pagamento dos cursos');
    $transaction->setInvoiceNumber($uniqid);

    $redirectUrls = new RedirectUrls;
    $redirectUrls->setReturnUrl('http://localhost:8888/pages/return_paypal.php?success=true');
    $redirectUrls->setCancelUrl('http://localhost:8888/pages/return_paypal.php?success=false');

    $payment = new Payment;
    $payment->setIntent('sale');
    $payment->setPayer($payer);
    $payment->setRedirectUrls($redirectUrls);
    $payment->setTransactions([$transaction]);

    try{
        $payment->create($api->api);
        $retornoPaypal = [
            'satate' => $payment->getState(),
            'link' => $payment->getApprovalLink()
        ];

        echo json_encode($retornoPaypal);

    }catch(PayPal\Exception\PayPalConnectionException $e){
        var_dump($e->getData());
    }

}