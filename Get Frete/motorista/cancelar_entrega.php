<?php
    require("../database/funcoes.php");
    $pedido = $_POST["id_p"];
    cancelarEntrega($pedido);
    header("Location:perfil.php");
?>