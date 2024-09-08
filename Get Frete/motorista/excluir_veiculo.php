<?php 
    require("../database/funcoes.php");
    $renavam = $_POST["renavam"];
    excluirVeiculo($renavam);
    header("Location:perfil.php");
?>