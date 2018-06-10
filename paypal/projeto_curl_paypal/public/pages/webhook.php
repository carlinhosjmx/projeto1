<?php

$bodyReceived = file_get_contents('php://input');
return file_put_contents('retorno_paypal.txt', $bodyReceived);