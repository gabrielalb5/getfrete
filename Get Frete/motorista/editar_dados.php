<?php 
    require("../database/funcoes.php");
    $_SESSION["email"] = $_SESSION["logado"];
    $_SESSION["nova_img"] = $_FILES["perfil_img"];
    $_SESSION["nova_cnh_img"] = $_FILES["cnh_img"];
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $senha = $_POST["senha"];
    $cpf = $_POST["cpf"];
    $telefone = $_POST["telefone"];
    $uf = $_POST["uf"];
    $cidade = $_POST["cidade"];
    $validade_cnh = $_POST["validade_cnh"];
    if(isset($_POST["pagamento"])){
        $dados = $_POST["pagamentos"];
        $pagamentos = implode(", ",$dados);
    }else{
        $pagamentos = $_SESSION["usuario"]["pagamentos"];
    }
    if($uf==""){$uf = $_SESSION["usuario"]["uf"];}
    if($cidade==""){$cidade = $_SESSION["usuario"]["cidade"];}
    updateMotorista($nome,$sobrenome,$senha,$cpf,$telefone,$uf,$cidade,$pagamentos);
    updateCNH($validade_cnh);
    if(!empty($_SESSION["nova_img"]["name"])){
        updateImagemMotorista();};
    if(!empty($_SESSION["nova_cnh_img"]["name"])){
        updateImagemCNH();};
    header("Location:perfil.php");
?>