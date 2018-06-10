$(document).ready(function(){

    var container = $('.container');
    var btn_renovar = container.find('#btn-renovar');

    btn_renovar.on('click', function(event){
        event.preventDefault();

        $.ajax({
            url: 'ajax/renovar_assinatura.php',
            type: 'GET',
            success: function(data){
                console.log(data);
            }
        });
    });

});