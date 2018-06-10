<?php

require '../../config.php';

use PayPal\Api\CancelNotification;
use PayPal\Api\Invoice;
use App\Models\Site\Invoice as InvoiceModel;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = filter_input(INPUT_POST,'id', FILTER_SANITIZE_NUMBER_INT);

    $invoiceModel = new InvoiceModel();
    $faturaEncontrada = $invoiceModel->find('id',$id);

    if(!$faturaEncontrada){
        echo json_encode('invoiceNotFound');
        die();
    }

     try{
        $cancel = new CancelNotification();
        $cancel->setSubject('Cancelando fatiura')
               ->setNote('Fatura foi com o valor errado')
               ->setSendToMerchant(true)
               ->setSendToPayer(true);

        $invoice = new Invoice;
        $invoice->setId($faturaEncontrada->invoice_id);
        $cancelStatus = $invoice->cancel($cancel,$api->api);

        if($cancelStatus){
            $statusInvoice = Invoice::get($faturaEncontrada->invoice_id, $api->api);

            if($statusInvoice->status == 'CANCELLED'){
                $invoiceModel->update($id, $statusInvoice->status);
                echo json_encode('cancelled');
                die();
            }else{
                echo json_encode('notCancelled');
                die();
            }
        }
    }catch(PayPal\Exception\PayPalConnectionException $e){
        var_dump($e->getData());
    }

}