<?php include("../include/cabecalho_inicio.php");
    $_SESSION["numero_cnh"] = $_POST["numero_cnh"];
    $_SESSION["validade_cnh"] = $_POST["validade_cnh"];
    //var_dump($_SESSION);
    cadastrarMotorista();
?>
<div class="cadastro">
<div class="form-cad">
    <h2><?php echo $_SESSION["h2"];?></h2>
    <p><?php echo $_SESSION["p"];?></p>
    <button class="btn" id="btn_azul" onclick="red_index()">Início</button>
    <button class="btn btn-light" id="btn_branco" onclick="red_cad_motorista()"><span class="material-symbols-outlined">arrow_back</span> Cadastrar motorista</button>
</div>
</div>
<?php include("../include/rodape_inicio.php");?>