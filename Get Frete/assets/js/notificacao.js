$('#notif_del').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: '../src/notif_apagar.php',
        method: 'POST',
        dataType: 'json'
    });
});
$('#notif_read').submit(function(e){
    e.preventDefault();
    $.ajax({
        url: '../src/notif_lidas.php',
        method: 'POST',
        dataType: 'json'
    });
});
$(document).ready(function() {
    function atualizarNotificacoes() {
        $.ajax({
            url: '../src/lista_notif.php',
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                $('#notif_box').html(data);
            },
            error: function() {
                console.log('Erro ao carregar notificações.');
            }
        });
    }
    function atualizarBolinha() {
        $.ajax({
            url: '../src/bolinha_notif.php',
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                $('.contador_notificacao').html(data);
            },
            error: function() {
                console.log('Erro ao carregar notificações.');
            }
        })
    }
    atualizarNotificacoes();
    atualizarBolinha();
    setInterval(atualizarNotificacoes, 1000);
    setInterval(atualizarBolinha, 1000);
});
