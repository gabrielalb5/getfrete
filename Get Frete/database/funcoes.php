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
    //ImagemMotorista();
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
//Cadastro das imagens
function ImagemCliente(){
    $imagem = $_SESSION["perfil"];
    $email = $_SESSION["email"];
    $pasta = "../arquivos/clientes/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    move_uploaded_file($imagem['tmp_name'], $path);
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    //só funciona se for ao contrário? estranho
    if($deu_certo==false){
        $conexao = obterConexao();
        $sql = "INSERT INTO imagens_cliente (nome, path, email, extensao) VALUES (?,?,?,?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss", $novoNomeDoArquivo, $path, $email, $extensao);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }
}
/*function ImagemMotorista(){
    $imagem = $_SESSION["perfil"];
    $email = $_SESSION["email"];
    $pasta = "../arquivos/motoristas/perfil/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    move_uploaded_file($imagem['tmp_name'], $path);
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
}*/

//Limpar sessão com dados de cadastro
function LimparCadastro(){
    unset($_SESSION["nome"], $_SESSION["sobrenome"], $_SESSION["nome_social"], $_SESSION["email"], $_SESSION["senha"], $_SESSION["senha_conf"], $_SESSION["cpf"], $_SESSION["telefone"], $_SESSION["uf"], $_SESSION["cidade"], $_SESSION["numero_cnh"], $_SESSION["validade_cnh"], $_SESSION["perfil"]);
}

function login($email,$senha,$opcao_login){
    var_dump($opcao_login);
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
                $_SESSION["logado"] = $email;
                header("Location:../logado/motorista/inicio_motorista.php");
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
                $_SESSION["logado"] = $email;
                header("Location:../logado/cliente/inicio_cliente.php");
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
?>