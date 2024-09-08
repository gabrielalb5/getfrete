<?php
    require("../database/funcoes.php");
    $pedido = $_POST["id_p"];
    excluirPedido($pedido);
    header("Location:perfil.php");
?>