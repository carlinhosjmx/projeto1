<?php

namespace App\Classes\Paypal;

use App\Classes\Paypal\Token;

class Paypal {

    protected $token;

    public function __construct() {
        $token = new Token;
        $this->token = $token->token();
    }

}
