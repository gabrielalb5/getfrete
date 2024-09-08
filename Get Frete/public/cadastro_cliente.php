<?php include("../include/cabecalho_inicio.php");?>
<div class="cadastro">
<div class="form-cad">
    <h2>Cadastro de cliente</h2>
    <h5 class="text-secondary">informações iniciais</h5>
    <form action="cadastro_cliente2.php" method="post" id="cadastro-form">
        <div class="textfield">
            <label for="email">E-mail</label>
            <input type="email" placeholder="E-mail" id="email" name="email" value="<?php if(isset($_SESSION["email"])){echo $_SESSION["email"];}; ?>" required></br>
        </div>
    <div id="colunas">
        <div id="col1">
            <div class="textfield">
                <label for="nome">Nome</label>
                <input type="text" placeholder="Nome" id="nome" name="nome" value="<?php if(isset($_SESSION["nome"])){echo $_SESSION["nome"];}; ?>" required>
            </div>
            <div class="textfield">
                <label for="sobrenome">Sobrenome</label>
                <input type="text" placeholder="Sobrenome" id="sobrenome" name="sobrenome" value="<?php if(isset($_SESSION["sobrenome"])){echo $_SESSION["sobrenome"];}; ?>" required>
            </div>
        </div>
        <div id="col2">
            <div class="textfield">
                <label for="senha">Senha</label>
                <input type="password" placeholder="Senha" id="senha" name="senha" value="<?php if(isset($_SESSION["senha"])){echo $_SESSION["senha"];}; ?>" required>
            </div>
            <div class="textfield">
                <label for="senha_conf">Confirme a senha</label>
                <input type="password" placeholder="Redigite a senha" id="senha_conf" name="senha_conf" required>
            </div>
        </div>
    </div>
    <p id="mensagem"></p>
    <input type="submit" value="Continuar" class="btn" id="btn_azul" onclick="return verificarSenha()"/>
    <button class="btn btn-light" id="btn_branco" onclick="red_cadastro()"><span class="material-symbols-outlined">arrow_back</span> Voltar</button>
    </form>
</div>
</div>
<?php include("../include/rodape_inicio.php");?>