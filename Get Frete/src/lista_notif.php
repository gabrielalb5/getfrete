<?php 
require("../database/funcoes.php");
$resultado = listar_notificacoes();
$lista_notificacoes = $resultado['notificacoes'];
if(empty($lista_notificacoes)){
    echo '<p class="text-center p-3 m-0">Não há notificações</p>';
    };?>
    <?php foreach($lista_notificacoes as $notificacao): ?>
    <?php
    if($notificacao["status"]=="1"){
        //notificação não lida
        echo '<p class="notificacao">'.$notificacao["msg"].'</p>';
    }else{
        echo '<p class="notificacao-lida">'.$notificacao["msg"].'</p>';
    };?>
<?php endforeach ?>