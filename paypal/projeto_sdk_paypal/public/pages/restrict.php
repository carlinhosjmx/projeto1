<?php

require '../../config.php';

use App\Classes\Login;
use App\Models\Site\Members;

$login = new Login();
if(!$login->isLoggedIn()){
    header('location:/');
}

$member = new Members;
if(!$member->isMember($_SESSION['id'])){
    header('location:/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Área restrita</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css">
</head>
<body>
<div class="row">
    <div class="col-sm-offset-4 col-sm-4" id="box">
    <a href="/" class="btn btn-success btn-xs" style="margin-top: 10px;">Voltar para o início</a>
    <h2><i class="fa fa-check-circle-o" aria-hidden="true" style="color: green;"></i>
        Parabéns <?php echo $_SESSION['name']; ?>, seu pagamento foi aceito e agora você tem acesso a área restrita</h2>
        <div><a href=""><i class="fa fa-download" aria-hidden="true"></i> clique aqui e faça o download do curso</a></div>
    </div>
</div>
</body>
</html>