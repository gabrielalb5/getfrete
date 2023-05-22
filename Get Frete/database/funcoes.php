<?php
require_once("conecta_bd.php");
if (!isset($_SESSION)){
    session_start();
}
//Cadastro de Usuários (Cliente e Motorista)
function verificaEmail(){
    $usuario = $_SESSION;
    $conexao = obterConexao();
    $sql = "SELECT email FROM motorista WHERE email = ? 
    UNION SELECT email FROM cliente WHERE email = ?
    UNION SELECT email FROM cnh WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sss", $usuario["email"],$usuario["email"],$usuario["email"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}
function verificaCNH(){
    $cnh = $_SESSION;
    $conexao = obterConexao();
    $sql = "SELECT * FROM cnh WHERE numero = ? OR email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $cnh["numero_cnh"],$cnh["email"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}
function cadastrarCliente(){
    $conexao = obterConexao();
    $cliente = $_SESSION;
    $resultado = verificaEmail();
    if (mysqli_num_rows($resultado)>0){
        $_SESSION["h2"] = "E-mail já cadastrado!";
        $_SESSION["p"] = "Volte e insira novos dados";
        return;
    } else {
        $senha_md5 = md5($cliente["senha"]);
        $sql = "INSERT INTO cliente (nome, sobrenome, nome_social, email, senha, cpf, telefone, uf, cidade) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssssssss", $cliente["nome"], $cliente["sobrenome"], $cliente["nome_social"], $cliente["email"], $senha_md5, $cliente["cpf"], $cliente["telefone"], $cliente["uf"], $cliente["cidade"]);
        $stmt->execute();
        $stmt->close();
        $_SESSION["h2"] = "Bem-vindo ao time!";
        $_SESSION["p"] = 'Acesse seu perfil em "Entrar"';
    }
    $conexao->close();
    ImagemCliente();
    LimparCadastro();
}
function cadastrarMotorista(){
    $conexao = obterConexao();
    $motorista = $_SESSION;
    $resultado = verificaEmail();
    if (mysqli_num_rows($resultado)>0){
        $_SESSION["h2"] = "E-mail já cadastrado!";
        $_SESSION["p"] = "Volte e insira novos dados";
        return;
    } else {
        $resultado = verificaCNH();
        if(mysqli_num_rows($resultado)>0){
            $_SESSION["h2"] = "CNH já cadastrada!";
            $_SESSION["p"] = "Volte e insira novos dados";
            return;
        }else{
            $senha_md5 = md5($motorista["senha"]);
            $sql = "INSERT INTO motorista (nome, sobrenome, nome_social, email, senha, cpf, telefone, uf, cidade)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sssssssss", $motorista["nome"], $motorista["sobrenome"], $motorista["nome_social"], $motorista["email"], $senha_md5, $motorista["cpf"], $motorista["telefone"], $motorista["uf"], $motorista["cidade"]);
            $stmt->execute();
            $stmt->close();
            $_SESSION["h2"] = "Bem-vindo ao time!";
            $_SESSION["p"] = 'Acesse seu perfil em "Entrar"';
        }
    }
    $conexao->close();
    cadastrarCNH();
    ImagemMotorista();
    LimparCadastro();
}
//Cadastro de CNH
function cadastrarCNH(){
    $conexao = obterConexao();
    $cnh = $_SESSION;
    $resultado = verificaCNH();
    if (mysqli_num_rows($resultado)>0){
        $_SESSION["h2"] = "CNH já cadastrada!";
        $_SESSION["p"] = "Volte e insira novos dados";
        return;
    } else {
        $sql = "INSERT INTO cnh (numero,validade,email)
        VALUES (?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sss", $cnh["numero_cnh"], $cnh["validade_cnh"], $cnh["email"]);
        $stmt->execute();
        $stmt->close();
    }
    $conexao->close();
    ImagemCNH();
}
//Cadastro das imagens
function ImagemCliente(){
    $imagem = $_SESSION["perfil_img"];
    $email = $_SESSION["email"];
    $pasta = "../assets/arquivos/clientes/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "INSERT INTO imagens_cliente (nome, path, email, extensao) VALUES (?,?,?,?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $novoNomeDoArquivo, $path, $email, $extensao);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }
}
function ImagemMotorista(){
    $imagem = $_SESSION["perfil_img"];
    $email = $_SESSION["email"];
    $pasta = "../assets/arquivos/motoristas/perfil/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "INSERT INTO imagens_motorista (nome, path, email, extensao) VALUES (?,?,?,?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $novoNomeDoArquivo, $path, $email, $extensao);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }
}
function ImagemCNH(){
    $imagem = $_SESSION["cnh_img"];
    $email = $_SESSION["email"];
    $pasta = "../assets/arquivos/motoristas/cnh/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . "cnh_" . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "INSERT INTO imagens_cnh (nome, path, email, extensao) VALUES (?,?,?,?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $novoNomeDoArquivo, $path, $email, $extensao);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }
}
//Limpar sessão com dados de cadastro
function LimparCadastro(){
    unset($_SESSION["nome"], $_SESSION["sobrenome"], $_SESSION["nome_social"], $_SESSION["email"], $_SESSION["senha"], $_SESSION["senha_conf"], $_SESSION["cpf"], $_SESSION["telefone"], $_SESSION["uf"], $_SESSION["cidade"], $_SESSION["numero_cnh"], $_SESSION["validade_cnh"], $_SESSION["perfil"]);
}
function login($email,$senha,$opcao_login){
    if($opcao_login=="motorista"){
        $conexao = obterConexao();
        $sql = "SELECT * FROM motorista WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if(mysqli_num_rows($resultado)>0){
            $senha_md5 = md5($senha);
            $sql = "SELECT * FROM motorista WHERE email = ? AND senha = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ss",$email,$senha_md5);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if(mysqli_num_rows($resultado)>0){
                $_SESSION["senha"] = $senha;
                $_SESSION["logado"] = $email;
                $_SESSION["perfil"] = $opcao_login;
                header("Location:../motorista/inicio.php");
            }else{
                $_SESSION["msg"] = 'Senha incorreta.';
                $_SESSION["tipo_msg"] = 'alert-danger';
                header("Location:../public/index.php");
            }
        }else{
            $_SESSION["msg"] = 'E-mail não cadastrado.';
            $_SESSION["tipo_msg"] = 'alert-danger';
            header("Location:../public/index.php");
        }
    }else{
        $conexao = obterConexao();
        $sql = "SELECT * FROM cliente WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if(mysqli_num_rows($resultado)>0){
            $senha_md5 = md5($senha);
            $sql = "SELECT * FROM cliente WHERE email = ? AND senha = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ss",$email,$senha_md5);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if(mysqli_num_rows($resultado)>0){
                $_SESSION["senha"] = $senha;
                $_SESSION["logado"] = $email;
                $_SESSION["perfil"] = $opcao_login;
                header("Location:../cliente/inicio.php");
            }else{
                $_SESSION["msg"] = 'Senha incorreta.';
                $_SESSION["tipo_msg"] = 'alert-danger';
                header("Location:../public/index.php");
            }
        }else{
            $_SESSION["msg"] = 'E-mail não cadastrado.';
            $_SESSION["tipo_msg"] = 'alert-danger';
            header("Location:../public/index.php");
        }
    }
}
function buscarUsuario(){
    $perfil = $_SESSION["perfil"];
    $conexao = obterConexao();
    if($perfil=="motorista"){
        $sql = "SELECT * FROM motorista WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $_SESSION["logado"]);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $_SESSION["usuario"] = mysqli_fetch_assoc($resultado);
        $stmt->close();
    }else{
        $sql = "SELECT * FROM cliente WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $_SESSION["logado"]);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $_SESSION["usuario"] = mysqli_fetch_assoc($resultado);
        $stmt->close();
    }
}
function buscarCNH(){
    $conexao = obterConexao();
    $sql = "SELECT * FROM cnh WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $_SESSION["logado"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $_SESSION["cnh"] = mysqli_fetch_assoc($resultado);
    $stmt->close();
}
function buscarImagem(){
    $perfil = $_SESSION["perfil"];
    $conexao = obterConexao();
    if($perfil=="motorista"){
        $sql = "SELECT * FROM imagens_motorista WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $_SESSION["logado"]);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $_SESSION["imagem"] = mysqli_fetch_assoc($resultado);
        $stmt->close();
    }else{
        $sql = "SELECT * FROM imagens_cliente WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $_SESSION["logado"]);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $_SESSION["imagem"] = mysqli_fetch_assoc($resultado);
        $stmt->close();
    }
}
function buscarImagemCNH(){
    $conexao = obterConexao();
    $sql = "SELECT * FROM imagens_cnh WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $_SESSION["logado"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $_SESSION["imagem_cnh"] = mysqli_fetch_assoc($resultado);
    $stmt->close();
}
function saudacao(){
    $usuario = $_SESSION["usuario"];
    $uf = $_SESSION["usuario"]["uf"];
    $c = $_SESSION["usuario"]["cidade"];
    if($uf=="AC"){
        date_default_timezone_set('America/Rio_Branco');
    }else if($uf=="AM" || $uf=="MT" || $uf=="MS" || $uf=="RO" || $uf=="RR"){
        date_default_timezone_set('America/Porto_Velho');
    }else if($c=="Fernando de Noronha"){
        date_default_timezone_set('America/Noronha');
    }else{
        date_default_timezone_set('America/Sao_Paulo');
    }
    $hora = date("H");
    if($hora>=6 && $hora<12){
        $saudacao = "Bom dia" . ', ' . $usuario["nome_social"];;
    }else if($hora>=12 && $hora<18){
        $saudacao = "Boa tarde" . ', ' . $usuario["nome_social"];;
    }else{
        $saudacao = "Boa noite" . ', ' . $usuario["nome_social"];;
    }
    return $saudacao;
}
function deslogado(){
    if(!isset($_SESSION["usuario"])){
        header("Location:../public/index.php");
    }
}
function logado(){
    if($_SESSION["perfil"] == "motorista"){
        header("Location:../motorista/inicio.php");
    }else{
        header("Location:../cliente/inicio.php");
    }
}
function logout(){
    session_destroy();
    header("Location:../public/index.php");
}
function updateCliente($nome,$sobrenome,$nome_social,$senha,$cpf,$telefone,$uf,$cidade){
    $email = $_SESSION["logado"];
    $conexao = obterConexao();
    $senha_md5 = md5($senha);
    $sql = "UPDATE cliente SET nome = ?, sobrenome = ?, nome_social = ?, senha = ?, cpf = ?, telefone = ?, uf = ?, cidade = ? WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssssss",$nome,$sobrenome,$nome_social,$senha_md5,$cpf,$telefone,$uf,$cidade,$email);
    $stmt->execute();
    if($stmt->affected_rows>0){
        $_SESSION["msg"] = 'Dados do usuário alterados com sucesso!';
        $_SESSION["tipo_msg"] = "alert-success";
        $_SESSION["senha"] = $senha;
    }
    $stmt->close();
    $conexao->close();
}
function updateMotorista($nome,$sobrenome,$nome_social,$senha,$cpf,$telefone,$uf,$cidade){
    $email = $_SESSION["logado"];
    $conexao = obterConexao();
    $senha_md5 = md5($senha);
    $sql = "UPDATE motorista SET nome = ?, sobrenome = ?, nome_social = ?, senha = ?, cpf = ?, telefone = ?, uf = ?, cidade = ? WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssssss",$nome,$sobrenome,$nome_social,$senha_md5,$cpf,$telefone,$uf,$cidade,$email);
    $stmt->execute();
    if($stmt->affected_rows>0){
        $_SESSION["msg"] = 'Dados do usuário alterados com sucesso!';
        $_SESSION["tipo_msg"] = "alert-success";
        $_SESSION["senha"] = $senha;
    }
    $stmt->close();
    $conexao->close();
}
function updateCNH($validade_cnh){
    $email = $_SESSION["logado"];
    $conexao = obterConexao();
    $sql = "UPDATE cnh SET validade = ? WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss",$validade_cnh,$email);
    $stmt->execute();
    $stmt->close();
    $conexao->close();
}
function updateImagemMotorista(){
    $imagem = $_SESSION["nova_img"];
    $email = $_SESSION["email"];
    $pasta = "../assets/arquivos/motoristas/perfil/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    unlink($_SESSION["imagem"]["path"]);
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "UPDATE imagens_motorista SET nome = ?, path = ?, extensao = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $novoNomeDoArquivo, $path, $extensao, $email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();  
    }
    unset($_SESSION["nova_img"]);
}
function updateImagemCliente(){
    $imagem = $_SESSION["nova_img"];
    $email = $_SESSION["email"];
    $pasta = "../assets/arquivos/clientes/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    unlink($_SESSION["imagem"]["path"]);
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "UPDATE imagens_cliente SET nome = ?, path = ?, extensao = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $novoNomeDoArquivo, $path, $extensao, $email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }
    unset($_SESSION["nova_img"]);
}
function updateImagemCNH(){
    buscarImagemCNH();
    $imagem = $_SESSION["nova_cnh_img"];
    $email = $_SESSION["email"];
    $pasta = "../assets/arquivos/motoristas/cnh/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . "cnh_" . $novoNomeDoArquivo . "." . $extensao;
    unlink($_SESSION["imagem_cnh"]["path"]);
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "UPDATE imagens_cnh SET nome = ?, path = ?, extensao = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $novoNomeDoArquivo, $path, $extensao, $email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }
    unset($_SESSION["nova_cnh_img"]);
}
function excluirUsuario($email){
    $conexao = obterConexao();
    $perfil = $_SESSION["perfil"];
    $perfil_img = $_SESSION["imagem"];
    if($perfil=="motorista"){
        buscarImagemCNH();
        $cnh_img = $_SESSION["imagem_cnh"];
        $sql = "DELETE FROM imagens_cnh WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $sql = "DELETE FROM cnh WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $sql = "DELETE FROM imagens_motorista WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $sql = "DELETE FROM motorista WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
        unlink($perfil_img["path"]);
        unlink($cnh_img["path"]);
        logout();
    }else{
        $sql = "DELETE FROM imagens_cliente WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $sql = "DELETE FROM cliente WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
        unlink($perfil_img["path"]);
        logout();
    }
}
?>