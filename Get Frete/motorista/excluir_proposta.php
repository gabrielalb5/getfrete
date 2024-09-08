<?php
    require("../database/funcoes.php");
    $pedido = $_POST["id_p"];
    excluirProposta($pedido);
    header("Location:perfil.php");
?>