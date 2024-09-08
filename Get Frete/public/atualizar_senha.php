<?php include("../include/cabecalho_inicio.php");?>
<?php
        $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);
        $conexao = obterConexao();
        $sql = "SELECT 'motorista' as tabela, email, nome FROM motorista WHERE recuperar_senha = ? 
        UNION SELECT 'cliente' as tabela, email, nome FROM cliente WHERE recuperar_senha = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss",$chave,$chave);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();
        if(mysqli_num_rows($resultado)>0){
            $row = mysqli_fetch_assoc($resultado);
            $tabela = $row['tabela'];
            $email = $row['email'];
        }else{
            $_SESSION["msg"] = 'Link inválido. Solicite uma nova chave em "Esqueci a senha".';
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location:index.php");
        }
?>
<div id="titulo">
  <h2>Alterar senha</h2>
</div>
<div class="container">
    <form action="nova_senha.php" method="post">
        <div class="textfield">
            <label for="senha">Digite sua nova senha</label>
            <input type="password" placeholder="Senha" id="senha" name="senha" required>
        </div>
        <div class="textfield">
            <label for="senha_conf">Confirme a senha</label>
            <input type="password" placeholder="Redigite a senha" id="senha_conf" name="senha_conf" required>
        </div>
        <p id="mensagem"></p>
        <input type="hidden" name="tabela" value="<?php echo $tabela ?>">
        <input type="hidden" name="email" value="<?php echo $email?>">
        <input type="submit" value="Confirmar" class="btn" id="btn_azul" onclick="return verificarSenha()"/>
    </form>
</div>
<?php include("../include/rodape_inicio.php");?>