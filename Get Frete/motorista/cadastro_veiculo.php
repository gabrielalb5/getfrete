<?php
    require("../database/funcoes.php");
    $_SESSION["email"] = $_SESSION["logado"];
    $tipo = $_POST["tipo"];
    $renavam = $_POST["renavam"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $placa = $_POST["placa"];
    $ano = $_POST["ano"];
    $cor = $_POST["cor"];
    cadastrarVeiculo($tipo,$renavam,$marca,$modelo,$placa,$ano,$cor);
    header("Location:perfil.php");
?>