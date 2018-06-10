<?php

namespace App\Classes\Paypal;

class Events{

    const CANCEL_INVOICE = 'INVOICING.INVOICE.CANCELLED';
    const PAYMENT_APPROVED = 'PAYMENT.SALE.COMPLETED';

    public function verifyEvent($data){
        switch($data['status']){
            case CANCEL_INVOICE:
                $validate = new ValidateInvoice($data);
                break;
            case PAYMENT_APPROVED:
                $validate = new ValidatePayment($data);
                break;

        }
    }


}