<?php require '../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Paypal</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="row">
        <div class="col-sm-offset-3 col-sm-6" id="box">
         <div id="bem-vindo">
            Seja bem vindo,
            <?php
                $login = new App\Classes\Login;
                echo ($login->isLoggedIn()) ? $_SESSION['name'] : 'Visitante';
             ?>
        </div>
        <div id="btn-logar">
            <?php
            if($login->isLoggedIn()){
                echo ' <a href="/pages/logout.php" class="btn btn-default btn-xs">
                       <i class="fa fa-sign-out" aria-hidden="true"></i>
                            Deslogar
                        </a>';
            }else{
                echo ' <a href="/pages/login.php" class="btn btn-default btn-xs"> <i class="fa fa-sign-out" aria-hidden="true"></i> Logar</a>';
            }
            ?>
        </div>
        <hr style="clear: both;">
                <?php
                    $page = filter_input(INPUT_GET,'p',FILTER_SANITIZE_STRING);
                    require pages($page);
                 ?>

                 <div style="clear: both;"></div>
                 <div id="message"></div>
            </div>
        <div>
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="assets/js/paypal_credit_card.js"></script>
    <script src="assets/js/paypal_environment.js"></script>
    <script src="assets/js/paypal_invoice.js"></script>
</body>
</html>