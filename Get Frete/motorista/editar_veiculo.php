<?php
    require("../database/funcoes.php");
    $tipo = $_POST["tipo"];
    $renavam = $_POST["renavam"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $placa = $_POST["placa"];
    $ano = $_POST["ano"];
    $cor = $_POST["cor"];
    updateVeiculo($tipo,$renavam,$marca,$modelo,$placa,$ano,$cor);
    header("Location:perfil.php");
?>