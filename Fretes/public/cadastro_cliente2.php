<?php include("../include/cabecalho_inicio.php");
    $_SESSION["nome"] = $_POST["nome"];
    $_SESSION["sobrenome"] = $_POST["sobrenome"];
    $_SESSION["nome_social"] = $_POST["nome_social"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["senha"] = $_POST["senha"];
?>
<div class="cadastro">
<div class="form-cad">
    <h2>Cadastro de cliente</h2>
    <h5>informações adicionais</h5>
    <form enctype="multipart/form-data" action="cadastro_cliente3.php" method="post">
    <div id="colunas">
        <div id="col1">
            <div class="textfield">
                <label for="cpf">CPF</label>
                <input type="text" placeholder="xxx.xxx.xxx-xx" id="cpf" name="cpf" maxlength="14" minlength="14" value="<?php if(isset($_SESSION["cpf"])){echo $_SESSION["cpf"];}; ?>" required></br>
            </div>
            <div class="textfield">
                <label for="telefone">Telefone</label>
                <input type="text" placeholder="(xx) xxxxx-xxxx" id="telefone" name="telefone" maxlength="15" minlength="14" value="<?php if(isset($_SESSION["telefone"])){echo $_SESSION["telefone"];}; ?>" required></br>
            </div>
            <div class="textfield">
                <label for="uf">UF</label>
                <select name="uf" id="uf" required>
                    <option value="">Escolha...</option>
                </select>
            </div>
        </div>
        <div id="col2">
        <div class="input-box">
            <label for="picture__input">Foto de perfil</label>
            <label class="picture" for="picture__input" tabIndex="0"><span class="picture__image"></span></label>
            <input type="file" accept="image/*" name="perfil" id="picture__input" required>
        </div>
            <div class="textfield">
                <label for="cidade">Cidade</label>
                <select name="cidade" id="cidade" required>
                    <option value="">Escolha...</option>
                </select>
            </div>
        </div>
    </div>
    <input type="submit" value="Finalizar" class="btn" id="btn_azul"/>
    <button class="btn btn-light" id="btn_branco" onclick="red_cad_cliente()"><span class="material-symbols-outlined">arrow_back</span> Voltar</button>
    </form>
</div>
</div>
<?php include("../include/rodape_inicio.php");?>