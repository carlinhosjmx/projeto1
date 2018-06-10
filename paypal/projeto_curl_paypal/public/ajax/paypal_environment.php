<?php

require '../../config.php';

use App\Classes\Login;
use App\Classes\Paypal\Payment;
use App\Models\Site\{Sale,Products};

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $login = new Login();
    if(!$login->isLoggedIn()){
        echo json_encode('notLoggedIn');
        die();
    }
    $uniqId = uniqid();

    $product = new Products;
    $amount = $product->amountProducts();
    $shipping = '15.00';
    $products = $product->all();
    $dataProducts = [];
    $totalProducts= '';

    foreach($products as $prod){
        $dataProducts[] = [
            'quantity' => 1,
            'name' => $prod->name,
            'price' => $prod->price,
            'sku' => $uniqId,
            'currency' => 'BRL'
        ];
        $totalProducts+=$prod->price;
    }

    // var_dump($dataProducts);

    $data = [
        'intent' => 'sale',
        'payer' => [
            'payment_method' => 'paypal'
        ],
        'redirect_urls' => [
            'return_url' => 'http://localhost:8888/pages/return_paypal.php',
            'cancel_url' => 'http://localhost:8888/pages/cancel_paypal.php'
        ],
        'transactions' => array([
            'amount' =>[
                'total' => ($totalProducts + $shipping),
                'currency' => 'BRL',
                'details' => [
                    'subtotal' => $totalProducts,
                    'shipping' => $shipping,
                    'tax' => '0.00'
                    ]
                ],
                'description' => 'Pagamento dos curso php sem medo',
                'item_list' => [
                    'items' => $dataProducts
                ]
        ])
    ];

    $payment = new Payment;
    $retorno = $payment->payment($data);

    // var_dump($retorno);

    $retornoPaypal = [
        'state' => $retorno->state,
        'link' => $retorno->links[1]->href
    ];

    $sale = new Sale();
    $sale->create($retorno->id,2,$_SESSION['id']);

    echo json_encode($retornoPaypal);

}