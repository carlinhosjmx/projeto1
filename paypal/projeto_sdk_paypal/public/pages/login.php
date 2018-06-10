<?php
require '../../config.php';

use App\Models\Site\Login;
use App\Models\Site\User;

if(isset($_POST['email'])){
    $login = new Login;
    $logado = $login->login(new User,$_POST);

    if($logado){
        $_SESSION['logado'] =true;
        $_SESSION['id']=$logado->id;
        $_SESSION['name']=$logado->name;
        session_regenerate_id();
        header('location:/');
    }
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4" id="box">

        <a href="/" class="btn btn-success btn-xs" style="margin-top:10px;"><i class="fa fa-paypal"></i> Voltar para o ínicio</a>

        <h2>Login</h2>
            <form method="post" action="">
                <label>E-mail</label>
                <input type="email" name="email" placeholder="Email" class="form-control" value="cursos@asolucoesweb.com.br"> <br>
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" class="form-control" value="123">
                <br>
                <button type="submit" class="btn btn-default">Logar</button>
            </form>
            <div id="message" style="margin-top: 10px;"></div>
        </div>
    </div>
</div>
</body>
</html>