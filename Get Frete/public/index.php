<?php include("../include/cabecalho_inicio.php");?>
<div class="main-login">
  <div id="left-login">
    <h2 id="texto_animado">Frete </h2><h3>solicite ou entregue</h3>
    <img src="../assets/img/caminhao.png" alt="Ilustração de caminhão." class="caminhao">
  </div>
  <div id="right-login">
  <div id="id_msg"></div>
    <div id="card-login">
    <p class="text-secondary">Novo por aqui? <a href="../public/cadastro.php">Cadastre-se</a></p>
    <h3>Entrar</h3>
        <form action="../src/recupera_login.php" method="post">
          <div id="opcao_login">
                <p>Perfil:</p>
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
                <input class="form-control" type="password" placeholder="Senha" id="senha" name="senha" required><span class="material-symbols-outlined" id="olho" onclick="ver_senha()">visibility_off</span></br>
                <a class="a link" data-bs-toggle="modal" data-bs-target="#recuperarsenha">Esqueci a senha</a></br>
            </div>
            <input type="submit" class="btn" id="btn_azul" value="Continuar">
        </form><br>
    </div>
    <!--Modal de recuperação de senha-->
    <div class="modal fade" id="recuperarsenha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Alterar senha</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="recuperar_senha.php" method="post">
              <div class="textfield">
                  <label for="email">Informe seu e-mail</label>
                  <input class="form-control" type="email" placeholder="E-mail" id="id_email" name="email" required>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("../include/rodape_inicio.php");?>