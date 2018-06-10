$(document).ready(function(){

    var container = $('.container');
    var btn_cancelar = container.find('#btn-cancelar');

    btn_cancelar.on('click', function(event){
        event.preventDefault();

        $.ajax({
            url: 'ajax/cancelar_assinatura.php',
            type: 'GET',
            success: function(data){
                console.log(data);
            }
        });
    });

});