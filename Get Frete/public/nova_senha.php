<?php
    require("../database/funcoes.php");
    $tabela = $_POST["tabela"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    novaSenha($tabela,$email,$senha);
    header("Location:index.php");
?>