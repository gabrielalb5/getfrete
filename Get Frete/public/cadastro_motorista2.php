<?php include("../include/cabecalho_inicio.php");
    $_SESSION["nome"] = $_POST["nome"];
    $_SESSION["sobrenome"] = $_POST["sobrenome"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["senha"] = $_POST["senha"];
?>
<div class="cadastro">
<div class="form-cad">
    <h2>Cadastro de motorista</h2>
    <h5 class="text-secondary">informações complementares</h5>
    <form enctype="multipart/form-data" action="cadastro_motorista3.php" method="post">
    <div id="colunas">
        <div id="col1">
            <div class="textfield">
                <label for="cpf">CPF</label>
                <input type="text" placeholder="xxx.xxx.xxx-xx" id="cpf" name="cpf" maxlength="14" minlength="14" value="<?php if(isset($_SESSION["cpf"])){echo $_SESSION["cpf"];}; ?>" required></br>
            </div>
            <div class="textfield">
                <label for="uf">UF</label>
                <select name="uf" id="uf" required>
                    <option value="">Escolha...</option>
                </select>
            </div>
            <div class="textfield">
                <label for="cidade">Cidade</label>
                <select name="cidade" id="cidade" required>
                    <option value="">Escolha...</option>
                </select>
            </div>
            <div class="textfield">
                <label for="telefone">Telefone</label>
                <input type="text" placeholder="(xx) xxxxx-xxxx" id="telefone" name="telefone" maxlength="15" minlength="14" value="<?php if(isset($_SESSION["telefone"])){echo $_SESSION["telefone"];}; ?>" required></br>
            </div>
        </div>
        <div id="col2">
        <div class="input-box">
            <label for="perfil_img">Foto de perfil</label>
            <label class="picture" for="perfil_img" tabIndex="0"><span class="perfil_img"></span></label>
            <input type="file" accept="image/*" name="perfil_img" id="perfil_img">
        </div>
        <div class="textfield">
                <label for="numero_cnh">CNH</label>
                <input type="text" placeholder="XXX.XXX.XXX-XX" id="numero_cnh" name="numero_cnh" maxlength="14" minlength="14" value="<?php if(isset($_SESSION["numero_cnh"])){echo $_SESSION["numero_cnh"];}; ?>" required>
        </div>
        <div class="textfield">
                <label for="data_min">Validade da CNH</label>
                <input type="date" id="data_min" name="validade_cnh" value="<?php if(isset($_SESSION["validade_cnh"])){echo $_SESSION["validade_cnh"];}; ?>" required></br>
        </div>
        </div>
    </div>
    <div class="input-box">
            <label for="cnh_img">Foto da CNH</label>
            <p class="text-danger">Imagem obrigatória</p>
            <label class="picture" id="cnh_preview" for="cnh_img" tabIndex="0"><span class="cnh_img"></span></label>
            <input type="file" accept="image/*" name="cnh_img" id="cnh_img" required>
    </div>
    <div class="text-field" id="pagamentos">
        <p class="form-check form-check-inline">Pagamentos aceitos:</p>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="pagamentos[]" id="dinheiro" value="Dinheiro" checked required>
            <label class="form-check-label" for="dinheiro">Dinheiro</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="pagamentos[]" id="pix" value="Pix">
            <label class="form-check-label" for="pix">Pix</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="pagamentos[]" id="credito" value="Crédito">
            <label class="form-check-label" for="credito">Crédito</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="pagamentos[]" id="debito" value="Débito">
            <label class="form-check-label" for="debito">Débito</label>
        </div>
    </div>
    <input type="submit" value="Finalizar" onclick="return Erros()" class="btn" id="btn_azul"/>
    <button class="btn btn-light" id="btn_branco" onclick="red_cad_motorista()"><span class="material-symbols-outlined">arrow_back</span> Voltar</button>
    </form>
</div>
</div>
<?php include("../include/rodape_inicio.php");?>