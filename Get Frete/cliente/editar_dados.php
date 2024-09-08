<?php 
    require("../database/funcoes.php");
    $_SESSION["email"] = $_SESSION["logado"];
    $_SESSION["nova_img"] = $_FILES["perfil_img"];
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $senha = $_POST["senha"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $uf = $_POST["uf"];
    $cidade = $_POST["cidade"];
    if($uf==""){$uf = $_SESSION["usuario"]["uf"];}
    if($cidade==""){$cidade = $_SESSION["usuario"]["cidade"];}
    updateCliente($nome,$sobrenome,$senha,$cpf,$telefone,$uf,$cidade);
    if(!empty($_SESSION["nova_img"]["name"])){
        updateImagemCliente();
    }
    header("Location:perfil.php");
?>