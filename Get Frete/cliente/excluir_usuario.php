<?php 
    require("../database/funcoes.php");
    $email = $_SESSION["logado"];
    excluirUsuario($email);
?>