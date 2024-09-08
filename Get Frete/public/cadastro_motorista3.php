<?php include("../include/cabecalho_inicio.php");
    $_SESSION["cpf"] = $_POST["cpf"];
    $_SESSION["telefone"] = $_POST["telefone"];
    $_SESSION["uf"] = $_POST["uf"];
    $_SESSION["cidade"] = $_POST["cidade"];
    $_SESSION["perfil_img"] = $_FILES["perfil_img"];
    $_SESSION["numero_cnh"] = $_POST["numero_cnh"];
    $_SESSION["validade_cnh"] = $_POST["validade_cnh"];
    $_SESSION["cnh_img"] = $_FILES["cnh_img"];
    $_SESSION["pagamentos"] = $_POST["pagamentos"];
    cadastrarMotorista();
?>
<div class="cadastro">
<div class="form-cad">
    <h2><?php echo $_SESSION["h2"];?></h2>
    <p><?php echo $_SESSION["p"];?></p>
    <button class="btn" id="btn_azul" onclick="red_index()">Entrar</button>
    <button class="btn btn-light" id="btn_branco" onclick="red_cad_motorista()"><span class="material-symbols-outlined">arrow_back</span> Cadastrar motorista</button>
</div>
</div>
<?php include("../include/rodape_inicio.php");?>