<?php include("../include/cabecalho_inicio.php");
    $_SESSION["cpf"] = $_POST["cpf"];
    $_SESSION["telefone"] = $_POST["telefone"];
    $_SESSION["estado"] = $_POST["estado"];
    $_SESSION["cidade"] = $_POST["cidade"];
    //var_dump($_SESSION);
    cadastrarCliente();
?>
<div class="cadastro">
<div class="form-cad">
    <h2><?php echo $_SESSION["h2"];?></h2>
    <p><?php echo $_SESSION["p"];?></p>
    <button class="btn" id="btn_azul" onclick="red_index()">Início</button>
    <button class="btn btn-light" id="btn_branco" onclick="red_cad_cliente()"><span class="material-symbols-outlined">arrow_back</span> Cadastrar cliente</button>
</div>
</div>
<?php include("../include/rodape_inicio.php");?>