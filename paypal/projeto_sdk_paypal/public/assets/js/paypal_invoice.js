$(document).ready(function () {

    var container = $('.container');
    var btn_submit_invoice = container.find('#btn-submit-invoice');
    var btn_cancelar_invoice = container.find('.btn-cancel-invoice');
    var btn_check_status_invoice = container.find('.btn-check-status-invoice');
    var email = container.find('#email');
    var valor = container.find('#valor');
    var message = container.find('#message');

    btn_submit_invoice.on('click', function () {

        $.ajax({
            url: '/ajax/paypal_invoice.php',
            type: 'post',
            data: 'email=' + email.val() + '&valor=' + valor.val(),
            dataType: 'json',
            beforeSend: function () {
                message.html("<div class='alert alert-success'>\n\
                <i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>\n\
                    Aguarde enquanto enquanto enviamos a cobrança para " + email.val() + " \n\
                </div>");
            },
            success: function (retorno) {
                console.log(retorno);

                if (retorno == 'notLogged') {
                    window.location.href = '/pages/notLoggedIn.php';
                }

                if (retorno == 'sent') {
                    message.html("<div class='alert alert-success'><i class='fa fa-check-circle fa-3x fa-fw'></i> Cobrança enviada com sucesso para " + email.val() + " </div>");
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            }
        });
    });


    btn_cancelar_invoice.on('click', function (event) {
        event.preventDefault();

        var id = $(this).attr('data-id');
        $.ajax({
            url: '/ajax/paypal_cancel_invoice.php',
            type: 'post',
            data: 'id=' + id,
            dataType: 'json',
            beforeSend: function () {
                message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Aguarde enquanto estamos cancelando a fatura</div>");
            },
            success: function (retorno) {
                console.log(retorno);
                if (retorno == 'cancelled') {
                    message.html("<div class='alert alert-success'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Essa fatura foi cancelada com sucesso !!</div>");
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }

                if (retorno == 'error') {
                    message.html("<div class='alert alert-danger'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Ocorreu um erro ao cancelar essa fatura, tente novamente em alguns segundos</div>");
                    setTimeout(function () {
                        location.reload();
                    }, 3000);
                }
            }
        });
    });


    btn_check_status_invoice.on('click', function (event) {
        event.preventDefault();

        var id = $(this).attr('data-id');

        $.ajax({
            url: '/ajax/paypal_check_status_invoice.php',
            type: 'POST',
            dataType: 'json',
            data: 'id=' + id,
            beforeSend: function () {
                message.html("<div class='alert alert-info'><i class='fa fa-spinner fa-spin fa-3x fa-fw'></i> Aguarde enquanto verificamos o status da fatura.</div>");
            },
            success: function (retorno) {
                console.log(retorno);
                message.html("<div class='alert alert-success'>\n\
                <i class='fa fa-check fa-3x'></i> \n\
                O status dessa fatura é " + retorno + ".\n\
                </div>");

            }
        });
    });

});