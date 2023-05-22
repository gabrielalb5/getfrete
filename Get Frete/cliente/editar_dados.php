<?php 
    require("../database/funcoes.php");
    $_SESSION["email"] = $_SESSION["logado"];
    $_SESSION["nova_img"] = $_FILES["perfil_img"];
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $nome_social= $_POST["nome_social"];
    $senha = $_POST["senha"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $uf = $_POST["uf"];
    $cidade = $_POST["cidade"];
    updateCliente($nome,$sobrenome,$nome_social,$senha,$cpf,$telefone,$uf,$cidade);
    if(!empty($_SESSION["nova_img"]["name"])){
        updateImagemCliente();
    }
    header("Location:perfil.php");
?>