<?php include("../include/cabecalho_inicio.php");
require("../util/mensagens.php");
exibir_msg();?>
<div class="main-login">
  <div id="left-login">
    <h2>Frete <span style="color:#5F9CB4">simplificado</span><h2><h3>solicite ou entregue</h3>
    <img src="../assets/img/caminhao.png" alt="Ilustração de caminhão." class="caminhao">
  </div>
  <div id="right-login">
  <div id="id_msg"></div>
    <div id="card-login">
    <p>Novo por aqui? <a href="../public/cadastro.php">Cadastre-se</a></p>
    <h3>Entrar</h3>
        <form action="../src/recupera_login.php" method="post">
          <div id="opcao_login">
                <p>Você é:</p>
                <input type="radio" id="cliente" value="cliente" name="opcao_login" required>
                <label for="cliente">Cliente</label>
                <input type="radio" id="motorista" value="motorista" name="opcao_login">
                <label for="motorista">Motorista</label>
            </div>
            <div class="textfield">
                <label for="email">E-mail</label>
                <input class="form-control" type="email" placeholder="E-mail" id="id_email" name="email" required>
            </div>
            <div class="textfield">
                <label for="senha">Senha</label>
                <input class="form-control" type="password" placeholder="Senha" id="id_senha" name="senha" required><span class="material-symbols-outlined" id="olho" onclick="ver_senha()">visibility</span></br>
                <a href="">Esqueci a senha</a></br>
            </div>
            <button class="btn" id="btn_azul">Continuar</button>
        </form><br>
    </div>
  </div>
</div>
<?php include("../include/rodape_inicio.php");?>