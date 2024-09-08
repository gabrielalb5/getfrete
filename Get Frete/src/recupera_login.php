<?php
    require("../database/funcoes.php");
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $opcao_login = $_POST["opcao_login"];
    login($email,$senha,$opcao_login);
?>