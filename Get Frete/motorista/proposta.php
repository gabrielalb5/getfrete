<?php
    require("../database/funcoes.php");
    $pedido = $_POST["pedido"];
    $valor = $_POST["valor"];
    $veiculo = $_POST["veiculo"];
    $email = $_SESSION["logado"];
    realizarProposta($pedido,$valor,$email,$veiculo);
    header("Location:inicio.php");
?>