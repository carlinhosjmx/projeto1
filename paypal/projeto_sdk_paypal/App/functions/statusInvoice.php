<?php

function statusInvoice($status){
    switch ($status) {
        case 'CANCELLED':
            return 'CANCELADO';
            break;
        case 'SENT':
            return 'ENVIADO';
            break;
        case 'MARKED_AS_PAID':
            return 'PAGO';
            break;
    }
}