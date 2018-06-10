$(document).ready(function () {

    var container = $('.container');
    var btn_submit_paypal = container.find('#btn-submit-paypal');
    var message = container.find('#message');

    btn_submit_paypal.on('click', function (event) {
        event.preventDefault();
        $.ajax({
            url: '/ajax/paypal_environment.php',
            type: 'post',
             dataType: 'json',
            beforeSend: function () {
                message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>Aguarde enquanto verificamos estamos te enviando para o paypal</div>");
            },
            success: function (retorno) {
                console.log(retorno);

                if (retorno == 'notLoggedIn') {
                    window.location.href = '/pages/notLoggedIn.php';
                }

                if (retorno.state == 'created') {
                    window.location.href = retorno.link;
                }
            }
        });
    });
});