<?php include("../include/cabecalho_inicio.php");
    $_SESSION["cpf"] = $_POST["cpf"];
    $_SESSION["telefone"] = $_POST["telefone"];
    $_SESSION["uf"] = $_POST["uf"];
    $_SESSION["cidade"] = $_POST["cidade"];
    $_SESSION["perfil"] = $_FILES["perfil"];
?>
<div class="cadastro">
<div class="form-cad">
    <h2>Cadastro de motorista</h2>
    <h5>dados da CNH</h5>
    <form enctype="multipart/form-data" action="cadastro_motorista4.php" method="post">
    <div id="colunas">
        <div id="col1">
            <div class="textfield">
                <label for="numero_cnh">CNH</label>
                <input type="text" placeholder="XXX.XXX.XXX-XX" id="numero_cnh" name="numero_cnh" maxlength="14" minlength="14" value="<?php if(isset($_SESSION["numero_cnh"])){echo $_SESSION["numero_cnh"];}; ?>" required>
            </div>
        </div>
        <div id="col2">
            <div class="textfield">
                <label for="validade_cnh">Validade</label>
                <input type="date" id="validade_cnh" name="validade_cnh" value="<?php if(isset($_SESSION["validade_cnh"])){echo $_SESSION["validade_cnh"];}; ?>" required></br>
            </div>
        </div>
    </div>
    <div class="input-box">
            <label for="picture__input">Imagem da CNH</label>
            <label class="picture2" for="picture__input" tabIndex="0"><span class="picture__image"></span></label>
            <input type="file" accept="image/*" name="picture__input" id="picture__input">
        </div>
    <input type="submit" value="Finalizar" class="btn" id="btn_azul"/>
    <button class="btn btn-light" id="btn_branco" onclick="red_cad_motorista2()"><span class="material-symbols-outlined">arrow_back</span> Voltar</button>
    </form>
</div>
</div>
<script>
function mascaraCNH(cnh) {
    cnh = cnh.replace(/\D/g, ""); // remove caracteres não numéricos
    cnh = cnh.replace(/(\d{3})(\d)/, "$1.$2"); // insere o primeiro ponto
    cnh = cnh.replace(/(\d{3})(\d)/, "$1.$2"); // insere o segundo ponto
    cnh = cnh.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // insere o traço
    return cnh;
}
const inputCNH = document.getElementById("numero_cnh");
inputCNH.addEventListener("input", function(event) {
    event.target.value = mascaraCNH(event.target.value);
});
</script>
<?php include("../include/rodape_inicio.php");?>