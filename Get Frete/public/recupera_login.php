<?php
    require("../database/funcoes.php");
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $opcao_login = $_POST["senha"];
    login($email,$senha,$opcao_login);
?>