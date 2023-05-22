<?php 
    require("../database/funcoes.php");
    $_SESSION["email"] = $_SESSION["logado"];
    $_SESSION["nova_img"] = $_FILES["perfil_img"];
    $_SESSION["nova_cnh_img"] = $_FILES["cnh_img"];
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $nome_social= $_POST["nome_social"];
    $senha = $_POST["senha"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $uf = $_POST["uf"];
    $cidade = $_POST["cidade"];
    $validade_cnh = $_POST["validade_cnh"];
    updateMotorista($nome,$sobrenome,$nome_social,$senha,$cpf,$telefone,$uf,$cidade);
    updateCNH($validade_cnh);
    if(!empty($_SESSION["nova_img"]["name"])){
        updateImagemMotorista();};
    if(!empty($_SESSION["nova_cnh_img"]["name"])){
        updateImagemCNH();};
    header("Location:perfil.php");
?>