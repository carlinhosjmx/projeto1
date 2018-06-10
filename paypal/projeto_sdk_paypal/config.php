<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');
setlocale(LC_MONETARY, 'pt_BR');

require 'vendor/autoload.php';
require 'App/functions/pages.php';
require 'App/functions/statusInvoice.php';

use App\Classes\Paypal\ApiConfig;

$api = new ApiConfig();
$api->config();