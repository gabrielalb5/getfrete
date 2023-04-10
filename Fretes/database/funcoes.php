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
        $sql = "INSERT INTO cliente (nome, sobrenome, nome_social, email, senha, cpf, telefone) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssssss", $cliente["nome"], $cliente["sobrenome"], $cliente["nome_social"], $cliente["email"], $senha_md5, $cliente["cpf"], $cliente["telefone"]);
        $stmt->execute();
        $stmt->close();
        $_SESSION["h2"] = "Bem-vindo ao time!";
        $_SESSION["p"] = 'Acesse seu perfil em "Entrar"';
    }
    $conexao->close();
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
            $_SESSION["h2"] = "CNH já cadastrado!";
            $_SESSION["p"] = "Volte e insira novos dados";
            return;
        }else{
            $senha_md5 = md5($motorista["senha"]);
            $sql = "INSERT INTO motorista (nome, sobrenome, nome_social, email, senha, cpf, telefone)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sssssss", $motorista["nome"], $motorista["sobrenome"], $motorista["nome_social"], $motorista["email"], $senha_md5, $motorista["cpf"], $motorista["telefone"]);
            $stmt->execute();
            $stmt->close();
            $_SESSION["h2"] = "Bem-vindo ao time!";
            $_SESSION["p"] = 'Acesse seu perfil em "Entrar"';
        }
    }
    $conexao->close();
    cadastrarCNH();
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
}
//Limpar sessão com dados de cadastro
function LimparCadastro(){
    unset($_SESSION["nome"], $_SESSION["sobrenome"], $_SESSION["nome_social"], $_SESSION["email"], $_SESSION["senha"], $_SESSION["senha_conf"], $_SESSION["cpf"], $_SESSION["telefone"], $_SESSION["estado"], $_SESSION["cidade"], $_SESSION["numero_cnh"], $_SESSION["validade_cnh"]);
}
?>