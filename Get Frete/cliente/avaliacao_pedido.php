<?php
    require("../database/funcoes.php");
    $avaliacao = $_POST["avaliacao"];
    $pedido = $_POST["id_p"];
    arquivarHistorico($pedido,$avaliacao);
    header("Location:inicio.php");
?>