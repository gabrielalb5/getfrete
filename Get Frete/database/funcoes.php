<?php require('../assets/mailer/src/PHPMailer.php');
require('../assets/mailer/src/SMTP.php');
require('../assets/mailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
        $_SESSION["h2"] = "<span class='material-symbols-outlined' style='font-size:35px;'>warning</span> E-mail já cadastrado!";
        $_SESSION["p"] = "Volte e insira novos dados";
        return;
    } else {
        $senha_md5 = md5($cliente["senha"]);
        $sql = "INSERT INTO cliente (nome, sobrenome, email, senha, cpf, telefone, uf, cidade) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssssssss", $cliente["nome"], $cliente["sobrenome"], $cliente["email"], $senha_md5, $cliente["cpf"], $cliente["telefone"], $cliente["uf"], $cliente["cidade"]);
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
        $_SESSION["h2"] = "<span class='material-symbols-outlined' style='font-size:35px;'>warning</span> E-mail já cadastrado!";
        $_SESSION["p"] = "Volte e insira novos dados";
        return;
    } else {
        $resultado = verificaCNH();
        if(mysqli_num_rows($resultado)>0){
            $_SESSION["h2"] = "<span class='material-symbols-outlined' style='font-size:35px;'>warning</span> CNH já cadastrada!";
            $_SESSION["p"] = "Volte e insira novos dados";
            return;
        }else{
            $dados = $motorista["pagamentos"];
            $pagamentos = implode(", ",$dados);
            $senha_md5 = md5($motorista["senha"]);
            $avaliacao = "Novato";
            $sql = "INSERT INTO motorista (avaliacao, nome, sobrenome, email, senha, cpf, telefone, uf, cidade, pagamentos)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ssssssssss", $avaliacao, $motorista["nome"], $motorista["sobrenome"], $motorista["email"], $senha_md5, $motorista["cpf"], $motorista["telefone"], $motorista["uf"], $motorista["cidade"], $pagamentos);
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
    if($imagem['tmp_name']==''){
        $path = "../assets/arquivos/semfoto.png";
        $conexao = obterConexao();
        $sql = "UPDATE cliente SET imagem = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $path, $email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }else{
        $pasta = "../assets/arquivos/clientes/";
        $nomeDoArquivo = $imagem['name'];
        $novoNomeDoArquivo = $email;
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
        $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
        $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
        if($deu_certo){
            $conexao = obterConexao();
            $sql = "UPDATE cliente SET imagem = ? WHERE email = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ss", $path, $email);
            $stmt->execute();
            $stmt->close();
            $conexao->close();
        }
    }
}
function ImagemMotorista(){
    $imagem = $_SESSION["perfil_img"];
    $email = $_SESSION["email"];
    if($imagem['tmp_name']==''){
        $path = "../assets/arquivos/semfoto.png";
        $conexao = obterConexao();
        $sql = "UPDATE motorista SET imagem = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $path, $email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }else{
        $pasta = "../assets/arquivos/motoristas/perfil/";
        $nomeDoArquivo = $imagem['name'];
        $novoNomeDoArquivo = $email;
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
        $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
        $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
        if($deu_certo){
            $conexao = obterConexao();
            $sql = "UPDATE motorista SET imagem = ?  WHERE email = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ss", $path, $email);
            $stmt->execute();
            $stmt->close();
            $conexao->close();
        }
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
        $sql = "UPDATE cnh SET imagem = ?  WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $path,$email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }
}
//Limpar sessão com dados de cadastro
function LimparCadastro(){
    unset($_SESSION["nome"], $_SESSION["sobrenome"], $_SESSION["email"], $_SESSION["senha"], $_SESSION["senha_conf"], $_SESSION["cpf"], $_SESSION["telefone"], $_SESSION["uf"], $_SESSION["cidade"], $_SESSION["numero_cnh"], $_SESSION["validade_cnh"], $_SESSION["perfil"]);
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
            $_SESSION["msg"] = 'Perfil incorreto ou e-mail não cadastrado.';
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
            $_SESSION["msg"] = 'Perfil incorreto ou e-mail não cadastrado.';
            $_SESSION["tipo_msg"] = 'alert-danger';
            header("Location:../public/index.php");
        }
    }
}
function buscarCliente(){
    $conexao = obterConexao();
    $sql = "SELECT * FROM cliente WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $_SESSION["logado"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if(mysqli_num_rows($resultado)==0){
        logout();
        $_SESSION["msg"] = "Faça login novamente.";
        $_SESSION["tipo_msg"] = "alert-danger";
        die();
    }
    $_SESSION["usuario"] = mysqli_fetch_assoc($resultado);
    $stmt->close();
    $conexao->close();
}
function buscarMotorista(){
    $conexao = obterConexao();
    $sql = "SELECT * FROM motorista WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $_SESSION["logado"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if(mysqli_num_rows($resultado)==0){
        logout();
        $_SESSION["msg"] = "Faça login novamente.";
        $_SESSION["tipo_msg"] = "alert-danger";
        die();
    }
    $_SESSION["usuario"] = mysqli_fetch_assoc($resultado);
    $stmt->close();
    $conexao->close();
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
        $saudacao = "Bom dia" . ', ' . $usuario["nome"].'!';;
    }else if($hora>=12 && $hora<18){
        $saudacao = "Boa tarde" . ', ' . $usuario["nome"].'!';;
    }else{
        $saudacao = "Boa noite" . ', ' . $usuario["nome"].'!';;
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
function updateCliente($nome,$sobrenome,$senha,$cpf,$telefone,$uf,$cidade){
    $email = $_SESSION["logado"];
    $conexao = obterConexao();
    $senha_md5 = md5($senha);
    $sql = "UPDATE cliente SET nome = ?, sobrenome = ?, senha = ?, cpf = ?, telefone = ?, uf = ?, cidade = ? WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ssssssss",$nome,$sobrenome,$senha_md5,$cpf,$telefone,$uf,$cidade,$email);
    $stmt->execute();
    if($stmt->affected_rows>0){
        $_SESSION["msg"] = 'Seus dados foram alterados.';
        $_SESSION["tipo_msg"] = "alert-warning";
        $_SESSION["senha"] = $senha;
    }
    $stmt->close();
    $conexao->close();
}
function updateMotorista($nome,$sobrenome,$senha,$cpf,$telefone,$uf,$cidade,$pagamentos){
    $email = $_SESSION["logado"];
    $conexao = obterConexao();
    $senha_md5 = md5($senha);
    $sql = "UPDATE motorista SET nome = ?, sobrenome = ?, senha = ?, cpf = ?, telefone = ?, uf = ?, cidade = ?, pagamentos = ? WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssssss",$nome,$sobrenome,$senha_md5,$cpf,$telefone,$uf,$cidade,$pagamentos,$email);
    $stmt->execute();
    if($stmt->affected_rows>0){
        $_SESSION["msg"] = 'Seus dados foram alterados.';
        $_SESSION["tipo_msg"] = "alert-warning";
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
    if($stmt->affected_rows>0){
        $_SESSION["msg"] = 'Seus dados foram alterados.';
        $_SESSION["tipo_msg"] = "alert-warning";
    }
    $stmt->close();
    $conexao->close();
}
function updateImagemMotorista(){
    $imagem = $_SESSION["nova_img"];
    $email = $_SESSION["email"];
    if($_SESSION["usuario"]["imagem"]!="../assets/arquivos/semfoto.png"){
        unlink($_SESSION["usuario"]["imagem"]);
    }
    $pasta = "../assets/arquivos/motoristas/perfil/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "UPDATE motorista SET imagem = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $path, $email);
        $stmt->execute();
        if($stmt->affected_rows>0){
            $_SESSION["msg"] = 'Seus dados foram alterados.';
            $_SESSION["tipo_msg"] = "alert-warning";
        }
        $stmt->close();
        $conexao->close();  
    }
    unset($_SESSION["nova_img"]);
}
function updateImagemCliente(){
    $imagem = $_SESSION["nova_img"];
    $email = $_SESSION["email"];
    if($_SESSION["usuario"]["imagem"]!="../assets/arquivos/semfoto.png"){
        unlink($_SESSION["usuario"]["imagem"]);
    }
    $pasta = "../assets/arquivos/clientes/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "UPDATE cliente SET imagem = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $path, $email);
        $stmt->execute();
        if($stmt->affected_rows>0){
            $_SESSION["msg"] = 'Seus dados foram alterados.';
            $_SESSION["tipo_msg"] = "alert-warning";
        }
        $stmt->close();
        $conexao->close();
    }
    unset($_SESSION["nova_img"]);
}
function updateImagemCNH(){
    $imagem = $_SESSION["nova_cnh_img"];
    $email = $_SESSION["email"];
    unlink($_SESSION["cnh"]["imagem"]);
    $pasta = "../assets/arquivos/motoristas/cnh/";
    $nomeDoArquivo = $imagem['name'];
    $novoNomeDoArquivo = $email;
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
    $path = $pasta . "cnh_" . $novoNomeDoArquivo . "." . $extensao;
    $deu_certo = move_uploaded_file($imagem['tmp_name'], $path);
    if($deu_certo){
        $conexao = obterConexao();
        $sql = "UPDATE cnh SET imagem = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss",$path, $email);
        $stmt->execute();
        if($stmt->affected_rows>0){
            $_SESSION["msg"] = 'Seus dados foram alterados.';
            $_SESSION["tipo_msg"] = "alert-warning";
        }
        $stmt->close();
        $conexao->close();
    }
    unset($_SESSION["nova_cnh_img"]);
}
function excluirUsuario($email){
    $conexao = obterConexao();
    $perfil = $_SESSION["perfil"];
    if($perfil=="motorista"){
        $sql = "SELECT * FROM pedido WHERE motorista = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if(mysqli_num_rows($resultado)>0){
            $_SESSION["msg"] = 'Não foi possível excluir o perfil. Você possui pedidos pendentes.';
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location:perfil.php");
            die();
        }
        $sql = "DELETE FROM proposta WHERE motorista = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $sql = "DELETE FROM veiculo WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $sql = "DELETE FROM cnh WHERE email = ?";
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
        unlink($_SESSION["cnh"]["imagem"]);
    }else{
        $sql = "SELECT * FROM pedido WHERE cliente = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if(mysqli_num_rows($resultado)>0){
            $_SESSION["msg"] = 'Não foi possível excluir o perfil. Você possui pedidos pendentes.';
            $_SESSION["tipo_msg"] = "alert-danger";
            header("Location:perfil.php");
            die();
        }
        $sql = "DELETE FROM cliente WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();
        $conexao->close();
    }
    if($_SESSION["usuario"]["imagem"]!="../assets/arquivos/semfoto.png"){
        unlink($_SESSION["usuario"]["imagem"]);
    }
    logout();
}
function verificaVeiculo($renavam,$placa){
    $conexao = obterConexao();
    $sql = "SELECT * FROM veiculo WHERE renavam = ? OR placa = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("is", $renavam,$placa);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}
function cadastrarVeiculo($tipo,$renavam,$marca,$modelo,$placa,$ano,$cor){
    $resultado = listarVeiculos();
    $conexao = obterConexao();
    $email = $_SESSION["email"];
    $resultado = verificaVeiculo($renavam, $placa);
    if(mysqli_num_rows($resultado)>0){
        $_SESSION["msg"] = "Veículo já cadastrado.";
        $_SESSION["tipo_msg"] = "alert-danger";
        return;
    }else{
        $sql = "INSERT INTO veiculo (tipo, renavam, marca, modelo, placa, ano, cor, email)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("issssiss", $tipo, $renavam, $marca, $modelo, $placa, $ano, $cor, $email);
        $stmt->execute();
        $stmt->close();
        $_SESSION["msg"] = "Veículo adicionado ao perfil!";
        $_SESSION["tipo_msg"] = "alert-success";
    }
    $conexao->close();
}
function listarTipoVeiculo(){
    $conexao = obterConexao();
    $lista_tv = [];
    $sql = "SELECT * FROM tipo_veiculo";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($tipo = mysqli_fetch_assoc($resultado)){
        array_push($lista_tv,$tipo);
    }
    $stmt->close();
    $conexao->close();
    return $lista_tv;
}
function listarVeiculos(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $lista_veiculos = [];
    $sql = "SELECT v.renavam, v.marca, v.modelo, v.placa, v.ano, v.cor, tv.id_tv, tv.nome as 'tipo'
    FROM veiculo v
    INNER JOIN tipo_veiculo tv ON v.tipo = tv.id_tv
    WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $_SESSION["veiculo_cont"] = mysqli_num_rows($resultado);
    while($veiculo = mysqli_fetch_assoc($resultado)){
        array_push($lista_veiculos,$veiculo);
    }
    $stmt->close();
    $conexao->close();
    return $lista_veiculos;
}
function updateVeiculo($tipo,$renavam,$marca,$modelo,$placa,$ano,$cor){
    $conexao = obterConexao();
    $sql = "UPDATE veiculo SET tipo = ?, marca = ?, modelo = ?, placa= ?, ano = ?, cor = ? WHERE renavam = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("isssiss",$tipo,$marca,$modelo,$placa,$ano,$cor,$renavam);
    $stmt->execute();
    if($stmt->affected_rows>0){
        $_SESSION["msg"] = 'Dados do veículo alterados!';
        $_SESSION["tipo_msg"] = "alert-warning";
    }
    $stmt->close();
    $conexao->close();
}
function excluirVeiculo($renavam){
    $conexao = obterConexao();
    $sql = "SELECT * FROM pedido WHERE veiculo = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s",$renavam);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if(mysqli_num_rows($resultado)>0){
        $_SESSION["msg"] = 'Não foi possível excluir o veículo. Ele faz parte de algum pedido pendente.';
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location:perfil.php");
        die();
    }
    $sql = "DELETE FROM veiculo WHERE renavam = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $renavam);
    $stmt->execute();
    if($stmt->affected_rows>0){
        $_SESSION["msg"] = 'Veículo excluído.';
        $_SESSION["tipo_msg"] = "alert-danger";
    }
    $stmt->close();
    $conexao->close();
}
function listarCategoriaPedido(){
    $conexao = obterConexao();
    $lista_cp = [];
    $sql = "SELECT * FROM categoria_pedido";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($categoria = mysqli_fetch_assoc($resultado)){
        array_push($lista_cp,$categoria);
    }
    $stmt->close();
    $conexao->close();
    return $lista_cp;
}
function criarPedido($email,$descricao,$categoria,$origem,$destino,$data_entrega,$horario,$ajudante,$status){
    $conexao = obterConexao();
    $sql = "INSERT INTO pedido (cliente, descricao, categoria, origem, destino, data_entrega, horario, ajudante, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssssss",$email,$descricao,$categoria,$origem,$destino,$data_entrega,$horario,$ajudante,$status);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $_SESSION["msg"] = 'Pedido enviado com sucesso!';
    $_SESSION["tipo_msg"] = "alert-success";
    $stmt->close();
    $conexao->close();
}
function listarPedidos_cliente(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $lista_pedidos = [];
    $sql = "SELECT p.id_p, p.descricao, p.origem, p.destino, p.data_entrega, p.horario, p.ajudante, p.valor, cp.nome as 'categoria' FROM pedido p
    INNER JOIN categoria_pedido cp ON p.categoria = cp.id_cp
    WHERE cliente = ? AND status = 'Novo' ORDER BY p.data_entrega";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($pedido = mysqli_fetch_assoc($resultado)){
        array_push($lista_pedidos,$pedido);
    }
    $stmt->close();
    $conexao->close();
    return $lista_pedidos;
}
function listarPedidos_motorista($cidade,$uf){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $lista_pedidos = [];
    $sql = "SELECT p.id_p, p.descricao, p.origem, p.destino, p.data_entrega, p.horario, p.ajudante, p.valor, p.status, cp.nome AS 'categoria'
    FROM pedido p
    INNER JOIN cliente c ON p.cliente = c.email
    INNER JOIN categoria_pedido cp ON p.categoria = cp.id_cp
    LEFT JOIN proposta pr ON p.id_p = pr.pedido AND pr.motorista = ?
    WHERE (p.origem LIKE '%$cidade%$uf%' OR p.destino LIKE '%$cidade%$uf%' OR (c.cidade = ? AND c.uf = ?)) AND pr.pedido IS NULL AND p.status = 'Novo'
    ORDER BY p.data_entrega";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sss",$email,$cidade,$uf);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($pedido = mysqli_fetch_assoc($resultado)){
        array_push($lista_pedidos,$pedido);
    }
    $stmt->close();
    $conexao->close();
    return $lista_pedidos;
}
function formataData($data){
    // Define um array associativo com os nomes dos meses em português
    $meses = array(
        1 => 'jan',
        2 => 'fev',
        3 => 'mar',
        4 => 'abr',
        5 => 'mai',
        6 => 'jun',
        7 => 'jul',
        8 => 'ago',
        9 => 'set',
        10 => 'out',
        11 => 'nov',
        12 => 'dez'
    );
    // Converte a data para o formato desejado com a abreviação do mês em português
    $dataFormatada = date('d', strtotime($data)) . ' ' . $meses[date('n', strtotime($data))] . ' ' . date('Y', strtotime($data));
    return $dataFormatada;
}
function formataHora($hora){
    $horaFormatada = substr($hora, 0, 5);
    return $horaFormatada;
}
function realizarProposta($pedido,$valor,$email,$veiculo){
    $conexao = obterConexao();
    //verificar se não cancelaram o pedido
    $sql = "SELECT * FROM pedido WHERE id_p = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $pedido);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if(mysqli_num_rows($resultado)==0){
        $_SESSION["msg"] = 'O pedido foi cancelado pelo cliente.';
        $_SESSION["tipo_msg"] = "alert-warning";
    }else{
        $sql = "INSERT INTO proposta (pedido, valor, motorista, veiculo)
        VALUES (?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ssss",$pedido,$valor,$email,$veiculo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $_SESSION["msg"] = 'Proposta enviada com sucesso!';
        $_SESSION["tipo_msg"] = "alert-success";
        $stmt->close();
        $conexao->close();
        $notificacao = "recebe_proposta";
        notificacao($pedido,$notificacao);
    };
}
function listarPropostas($pedido){
    $conexao = obterConexao();
    $lista_propostas = [];
    $sql = "SELECT pr.id_pr, pr.pedido,
    REPLACE(pr.valor, '.', ',') as valor,
    CONCAT(m.nome, ' ', m.sobrenome) AS motorista,
    tv.nome AS veiculo, v.placa, m.email, m.avaliacao, m.viagens, m.telefone, m.pagamentos AS pagamento
    FROM proposta pr
    INNER JOIN motorista m ON pr.motorista = m.email
    INNER JOIN veiculo v ON pr.veiculo = v.renavam
    INNER JOIN tipo_veiculo tv ON v.tipo = tv.id_tv
    WHERE pr.pedido = ? ORDER BY pr.id_pr";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $pedido);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($proposta = mysqli_fetch_assoc($resultado)){
        array_push($lista_propostas,$proposta);
    }
    $stmt->close();
    $conexao->close();
    return $lista_propostas;
}
//propostas feitas pelo motorista para aparecer no próprio perfil
function listarPropostas_motorista(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $lista_propostas_enviadas = [];
    $sql = "SELECT p.id_p, p.descricao, p.origem, p.destino, p.data_entrega, p.horario, p.ajudante, cp.nome AS 'categoria',
    REPLACE(pr.valor, '.', ',') as valor,
    tv.nome AS tipo_veiculo, v.placa
    FROM pedido p
    INNER JOIN proposta pr ON p.id_p = pr.pedido
    INNER JOIN categoria_pedido cp ON p.categoria = cp.id_cp 
    INNER JOIN motorista m ON pr.motorista = m.email
    INNER JOIN veiculo v ON pr.veiculo = v.renavam
    INNER JOIN tipo_veiculo tv ON v.tipo = tv.id_tv
    WHERE pr.motorista = ? ORDER BY p.data_entrega";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($proposta = mysqli_fetch_assoc($resultado)){
        array_push($lista_propostas_enviadas,$proposta);
    }
    $stmt->close();
    $conexao->close();
    return $lista_propostas_enviadas;
}
function excluirProposta($pedido){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $sql = "DELETE FROM proposta WHERE pedido = ?  AND motorista = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss",$pedido,$email);
    $stmt->execute();
    $_SESSION["msg"] = 'Proposta cancelada.';
    $_SESSION["tipo_msg"] = "alert-danger";
    $stmt->close();
    $conexao->close();
}
function excluirPedido($pedido){
    $notificacao = "pedido_excluido";
    notificacao($pedido,$notificacao);
    $conexao = obterConexao();
    $sql = "DELETE FROM proposta WHERE pedido = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i",$pedido);
    $stmt->execute();
    $stmt->close();
    $sql = "DELETE FROM pedido WHERE id_p = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i",$pedido);
    $stmt->execute();
    $stmt->close();
    $_SESSION["msg"] = 'Pedido excluído.';
    $_SESSION["tipo_msg"] = "alert-danger";
    $conexao->close();
}
function emailExiste($email){
    $conexao = obterConexao();
    $sql = "SELECT 'motorista' as tabela, email, nome FROM motorista WHERE email = ? 
    UNION SELECT 'cliente' as tabela, email, nome FROM cliente WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss",$email,$email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if(mysqli_num_rows($resultado)>0){
        $chave_recuperar_senha = password_hash($email, PASSWORD_DEFAULT);
        $row = mysqli_fetch_assoc($resultado);
        $tabela = $row['tabela'];
        $nome = $row['nome'];
        if($tabela=="cliente"){
            $sql = "UPDATE cliente SET recuperar_senha = ? WHERE email = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ss",$chave_recuperar_senha,$email);
            $stmt->execute();
            $stmt->close();
        }elseif($tabela=="motorista"){
            $sql = "UPDATE motorista SET recuperar_senha = ? WHERE email = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("ss",$chave_recuperar_senha,$email);
            $stmt->execute();
            $stmt->close();
        }
        $mail = new PHPMailer(true);
        $link = "http://localhost/tcc/Get%20Frete/public/atualizar_senha.php?chave=$chave_recuperar_senha";
        try{
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'getfrete@gmail.com';
            $mail->Password = 'gzqxcfobogcogyie';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'alow_self_signed' => true
                )
            );
            //Recipients
            $mail->setFrom('getfrete@gmail.com', 'Get Frete');
            $mail->addAddress($email, $nome);
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Alteração de senha';
            $mail->Body    = 'Olá, '.$nome.'!<br>Você solicitou a recuperação de senha.<br>Para continuar, clique no botão abaixo.
            <br><br><a href="'.$link.'" style="display: inline-block;padding: 10px 20px;text-align: center;text-decoration: none;color: #ffffff;background-color: #5F9CB4;border-radius: 6px;outline: none;transition: 0.3s;">Alterar senha</a><br><br>Se não foi você quem solicitou esta alteração, ignore esse e-mail.<br>Sua senha permanecerá a mesma.<br><br>Atenciosamente, equipe Get Frete.';
            $mail->AltBody = 'Olá, '.$nome.'!\nVocê solicitou a recuperação de senha.\nPara continuar, clique no link abaixo.
            \n\n<a href="'.$link.'">Alterar senha</a>\n\nSe não foi você quem solicitou esta alteração, ignore este e-mail.\nSua senha permanecerá a mesma.\n\nAtenciosamente, equipe Get Frete.';
            if($mail->send()) {
                $_SESSION["msg"] = 'Um e-mail com instruções foi enviado para você. ';
                $_SESSION["tipo_msg"] = "alert-success";
            } else {
                $_SESSION["msg"] = "E-mail não enviado. Erro do PHP Mailer: {$mail->ErrorInfo}";
                $_SESSION["tipo_msg"] = "alert-danger";
            }
        }catch (Exception $e){
            $_SESSION["msg"] = "E-mail não enviado. Erro do PHP Mailer: {$mail->ErrorInfo}";
            $_SESSION["tipo_msg"] = "alert-danger";
        }
    }else{
        $_SESSION["msg"] = 'E-mail não cadastrado.';
        $_SESSION["tipo_msg"] = "alert-danger";
    }
    $conexao->close();
    header("Location:index.php");
}
function novaSenha($tabela,$email,$senha){
    $conexao = obterConexao();
    $senha_md5 = md5($senha);
    if($tabela=="cliente"){
        $sql = "UPDATE cliente SET senha = ?, recuperar_senha = '' WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss",$senha_md5,$email);
        $stmt->execute();
        $stmt->close();
    }elseif($tabela=="motorista"){
        $sql = "UPDATE motorista SET senha = ?, recuperar_senha = '' WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss",$senha_md5,$email);
        $stmt->execute();
        $stmt->close();
    }
    $_SESSION["msg"] = 'Senha alterada com sucesso!';
    $_SESSION["tipo_msg"] = "alert-success";
    $conexao->close();
}
function escolherProposta($proposta_escolhida){
    $conexao = obterConexao();
    $sql = "SELECT pedido, motorista, veiculo, valor FROM proposta WHERE id_pr = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i",$proposta_escolhida);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if(mysqli_num_rows($resultado)>0){
        $proposta = mysqli_fetch_assoc($resultado);
            $pedido = $proposta["pedido"];
            $motorista = $proposta["motorista"];
            $veiculo = $proposta["veiculo"];
            $valor = $proposta["valor"];
        $sql = "UPDATE pedido SET motorista = ?, veiculo = ?, valor = ?, status = 'Confirmado' WHERE id_p = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sssi",$motorista,$veiculo,$valor,$pedido);
        $stmt->execute();
        $sql = "DELETE FROM proposta WHERE pedido = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("i",$pedido);
        $stmt->execute();
        if($stmt->affected_rows>0){
            $_SESSION["msg"] = 'Proposta escolhida com sucesso!';
            $_SESSION["tipo_msg"] = "alert-success";
        }
        $notificacao = "escolhe_proposta";
        notificacao($pedido,$notificacao);
    }else{
        $_SESSION["msg"] = 'A proposta foi revogada.';
        $_SESSION["tipo_msg"] = "alert-danger";
        header("Location:perfil.php");
    }
    $stmt->close();
    $conexao->close();
}
function listarPedidos_conf_cliente(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $lista_pedidos = [];
    $sql = "SELECT p.id_p, CONCAT(m.nome, ' ', m.sobrenome) AS motorista, REPLACE(p.valor, '.', ',') as valor, p.veiculo, m.telefone, p.descricao,
    p.origem, p.destino, p.data_entrega, p.horario, p.ajudante, cp.nome as 'categoria',
    tv.nome AS tipo_veiculo, v.placa, m.pagamentos AS pagamento
    FROM pedido p
    INNER JOIN veiculo v ON p.veiculo = v.renavam
    INNER JOIN tipo_veiculo tv ON v.tipo = tv.id_tv
    INNER JOIN motorista m ON m.email = p.motorista
    INNER JOIN categoria_pedido cp ON p.categoria = cp.id_cp
    WHERE cliente = ? AND status = 'Confirmado' OR status = 'Iniciado' ORDER BY CONCAT(p.data_entrega, ' ', p.horario)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($pedido = mysqli_fetch_assoc($resultado)){
        array_push($lista_pedidos,$pedido);
    }
    $stmt->close();
    $conexao->close();
    return $lista_pedidos;
}
function listarPedidos_conf_motorista(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $lista_pedidos = [];
    $sql = "SELECT p.id_p, CONCAT(c.nome, ' ', c.sobrenome) AS cliente, REPLACE(p.valor, '.', ',') as valor, p.veiculo, c.telefone, p.descricao,
    p.origem, p.destino, p.data_entrega, p.horario, p.ajudante, cp.nome as 'categoria',
    tv.nome AS tipo_veiculo, v.placa
    FROM pedido p
    INNER JOIN veiculo v ON p.veiculo = v.renavam
    INNER JOIN tipo_veiculo tv ON v.tipo = tv.id_tv
    INNER JOIN cliente c ON c.email = p.cliente
    INNER JOIN categoria_pedido cp ON p.categoria = cp.id_cp
    WHERE motorista = ? AND status = 'Confirmado' OR status = 'Iniciado' ORDER BY CONCAT(p.data_entrega, ' ', p.horario)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($pedido = mysqli_fetch_assoc($resultado)){
        array_push($lista_pedidos,$pedido);
    }
    $stmt->close();
    $conexao->close();
    return $lista_pedidos;
}
function proximaEntrega(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $sql = "SELECT id_p, data_entrega, horario, descricao
    FROM pedido p
    WHERE motorista = ? AND status = 'Confirmado'
    ORDER BY CONCAT(data_entrega, ' ', horario) LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $proxima_entrega = mysqli_fetch_assoc($resultado);
    $stmt->close();
    $conexao->close();
    return $proxima_entrega;
}
function iniciarEntrega($id_p){
    $conexao = obterConexao();
    //verificar se não cancelaram o pedido
    $sql = "SELECT * FROM pedido WHERE id_p = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $id_p);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if(mysqli_num_rows($resultado)==0){
        $_SESSION["msg"] = 'O pedido foi cancelado pelo cliente.';
        $_SESSION["tipo_msg"] = "alert-danger";
    }else{
        $sql = "UPDATE pedido SET status = 'Iniciado' WHERE id_p = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $id_p);
        $stmt->execute();
        $pedido = $id_p;
        $notificacao = "inicio_entrega";
        notificacao($pedido,$notificacao);
    }
    $stmt->close();
    $conexao->close();
}
function entregaIniciada(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $sql = "SELECT p.id_p, CONCAT(c.nome, ' ', c.sobrenome) AS cliente, REPLACE(p.valor, '.', ',') as valor, p.veiculo, c.telefone, p.descricao,
    p.origem, p.destino, p.data_entrega, p.horario, p.ajudante, cp.nome as 'categoria',
    tv.nome AS tipo_veiculo, v.placa
    FROM pedido p
    INNER JOIN veiculo v ON p.veiculo = v.renavam
    INNER JOIN tipo_veiculo tv ON v.tipo = tv.id_tv
    INNER JOIN cliente c ON c.email = p.cliente
    INNER JOIN categoria_pedido cp ON p.categoria = cp.id_cp
    WHERE motorista = ? AND status = 'Iniciado'
    ORDER BY CONCAT(data_entrega, ' ', horario) LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $entrega_iniciada = mysqli_fetch_assoc($resultado);
    $stmt->close();
    $conexao->close();
    return $entrega_iniciada;
}
function finalizarEntrega($id_p){
    $conexao = obterConexao();
    //verificar se não cancelaram o pedido
    $sql = "SELECT * FROM pedido WHERE id_p = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $id_p);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if(mysqli_num_rows($resultado)==0){
        $_SESSION["msg"] = 'O pedido foi cancelado pelo cliente.';
        $_SESSION["tipo_msg"] = "alert-danger";
    }else{
        //para pegar o timezone deve-se chamar a função de saudação
        saudacao();
        $finalizado = date("Y-m-d H:i:s");
        $sql = "UPDATE pedido SET status = 'Avaliacao', finalizado = ? WHERE id_p = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss",$finalizado,$id_p);
        $stmt->execute();
        $pedido = $id_p;
        $notificacao = "fim_entrega";
        notificacao($pedido,$notificacao);
    }
}
function status_avaliacao(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $lista_avaliacao = [];
    $sql = "SELECT p.id_p, CONCAT(m.nome, ' ', m.sobrenome) AS motorista, REPLACE(p.valor, '.', ',') as valor, p.veiculo, m.telefone, p.descricao,
    p.origem, p.destino, p.data_entrega, p.horario, p.ajudante, cp.nome as 'categoria',
    tv.nome AS tipo_veiculo, v.placa, m.pagamentos AS pagamento
    FROM pedido p
    INNER JOIN veiculo v ON p.veiculo = v.renavam
    INNER JOIN tipo_veiculo tv ON v.tipo = tv.id_tv
    INNER JOIN motorista m ON m.email = p.motorista
    INNER JOIN categoria_pedido cp ON p.categoria = cp.id_cp
    WHERE cliente = ? AND status = 'Avaliacao' ORDER BY CONCAT(p.data_entrega, ' ', p.horario)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($pedido = mysqli_fetch_assoc($resultado)){
        array_push($lista_avaliacao,$pedido);
    }
    $stmt->close();
    $conexao->close();
    return $lista_avaliacao;
}
function arquivarHistorico($pedido,$avaliacao){
    $conexao = obterConexao();
    $sql = "SELECT p.id_p, p.data_pedido, p.finalizado, CONCAT(p.descricao, ' - ',cp.nome) as descricao, p.origem, p.destino,
    p.data_entrega, p.horario, p.ajudante, REPLACE(p.valor, '.', ',') as valor,
    CONCAT(c.nome, ' ', c.sobrenome) AS cliente, c.cpf as cpf_c, c.email as email_c, c.telefone as tel_c,
    CONCAT(m.nome, ' ', m.sobrenome) AS motorista, m.cpf as cpf_m, m.email as email_m, m.telefone as tel_m,
    CONCAT(tv.nome, ' - ', v.placa,' | Renavam: ',p.veiculo) as veiculo
    FROM pedido p
    INNER JOIN veiculo v ON p.veiculo = v.renavam
    INNER JOIN tipo_veiculo tv ON v.tipo = tv.id_tv
    INNER JOIN motorista m ON m.email = p.motorista
    INNER JOIN cliente c ON c.email = p.cliente
    INNER JOIN categoria_pedido cp ON p.categoria = cp.id_cp
    WHERE id_p = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $pedido);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $p = mysqli_fetch_assoc($resultado);
    $stmt->close();
    $sql = "INSERT INTO historico (id_pedido,data_pedido,finalizado,descricao,origem,destino,data_entrega,horario,ajudante,valor,cliente,cpf_c,email_c,motorista,cpf_m,email_m,veiculo,avaliacao,tel_c,tel_m)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("issssssssssssssssiss",$p["id_p"],$p["data_pedido"],$p["finalizado"],$p["descricao"],$p["origem"],$p["destino"],$p["data_entrega"],$p["horario"],$p["ajudante"],$p["valor"],$p["cliente"],$p["cpf_c"],$p["email_c"],$p["motorista"],$p["cpf_m"],$p["email_m"],$p["veiculo"],$avaliacao,$p["tel_c"],$p["tel_m"]);
    $stmt->execute();
    $stmt->close();
    $sql = "DELETE FROM pedido WHERE id_p = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $pedido);
    $stmt->execute();
    $stmt->close();
    $_SESSION["msg"] = 'Obrigado por avaliar!';
    $_SESSION["tipo_msg"] = "alert-success";
    $motorista = $p["email_m"];
    avaliacao($motorista);
}
function avaliacao($motorista){
    $conexao = obterConexao();
    $sql = "SELECT  email_m,
            COUNT(avaliacao) AS quantidade,
            SUM(avaliacao) AS soma_das_avaliacoes,
            ROUND(SUM(avaliacao) / COUNT(avaliacao), 2) AS media
            FROM historico
            WHERE email_m = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s",$motorista);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $avaliacoes = mysqli_fetch_assoc($resultado);
    $stmt->close();
    if($avaliacoes["quantidade"] >= 10){
        $sql = "UPDATE motorista SET avaliacao = ?, viagens = ? WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sss",$avaliacoes["media"],$avaliacoes["quantidade"],$motorista);
        $stmt->execute();
        $stmt->close();
    }
    $conexao->close();
}
function historico($inicio,$limite){
    $perfil = $_SESSION["perfil"];
    $email = $_SESSION["logado"];
    $lista_historico = [];
    $conexao = obterConexao();
    if($perfil=="motorista"){
        $sql = "SELECT * FROM historico WHERE email_m = ? ORDER BY finalizado DESC LIMIT $inicio, $limite";
    }else{
        $sql = "SELECT * FROM historico WHERE email_c = ? ORDER BY finalizado DESC LIMIT $inicio, $limite";
    }
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($pedido = mysqli_fetch_assoc($resultado)){
        //função que exclui o texto após o | para preservar a privacidade do renavam
        $pedido['veiculo'] = excluirTextoAposPipe($pedido['veiculo']);
        array_push($lista_historico,$pedido);
    }
    return $lista_historico;
}
//não mostrar o renavam (privado para usuários)
function excluirTextoAposPipe($string) {
    $parts = explode("|", $string);
    return trim($parts[0]);
}
function arrayDataHora($dataHora){
    $timestamp = strtotime($dataHora);
        $meses = array(
            1 => 'jan',
            2 => 'fev',
            3 => 'mar',
            4 => 'abr',
            5 => 'mai',
            6 => 'jun',
            7 => 'jul',
            8 => 'ago',
            9 => 'set',
            10 => 'out',
            11 => 'nov',
            12 => 'dez'
        );
    // Formata a data e hora no formato desejado
    $dataFormatada = date('d', $timestamp) . ' ' . $meses[date('n', $timestamp)] . ' ' . date('Y', $timestamp);
    $horaFormatada = date('H:i', $timestamp);
    
    return $dataFormatada . ' às ' . $horaFormatada . 'h';
}
function notificacao($pedido,$notificacao){
    $conexao = obterConexao();
    $sql = "SELECT * FROM pedido WHERE id_p = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s",$pedido);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pedido = mysqli_fetch_assoc($resultado);
    $descricao = $pedido["descricao"];
    $status = "1";
    //mensagens variadas
    switch($notificacao){
        case "recebe_proposta":
            $usuario = $pedido["cliente"];
            $msg = 'Seu pedido "'.$descricao.'" recebeu uma <a href="../cliente/perfil.php">nova proposta</a>.';
            break;
        case "escolhe_proposta":
            $usuario = $pedido["motorista"];
            $msg = 'Sua <a href="../motorista/perfil.php">proposta</a> para "'.$descricao.'" foi escolhida.';
            break;
        case "inicio_entrega":
            $usuario = $pedido["cliente"];
            $msg = 'Entrega de "'.$descricao.'" iniciada.';
            break;
        case "fim_entrega":
            $usuario = $pedido["cliente"];
            $msg = 'Entrega de "'.$descricao.'" finalizada.<br>Para concluir, avalie-a em <a href="../cliente/inicio.php">Início</a>.';
            break;
        case "pedido_excluido":
            $usuario = $pedido["motorista"];
            $msg = 'A entrega de "'.$descricao.'" foi cancelada pelo cliente.';
            break;
        case "entrega_cancelada":
            $usuario = $pedido["cliente"];
            $msg = 'A entrega de "'.$descricao.'" foi cancelada pelo motorista.';
            break;
    }
    $sql = "INSERT INTO notificacao (pedido, usuario, msg, status) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("issi",$pedido,$usuario,$msg,$status);
    $stmt->execute();
    $stmt->close();
    $conexao->close();
}
function listar_notificacoes(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $lista_notificacoes = [];
    $contador_nao_lidas = 0;
    $sql = "SELECT * FROM notificacao WHERE usuario = ? ORDER BY id_n DESC";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while($notificacao = mysqli_fetch_assoc($resultado)){
        array_push($lista_notificacoes,$notificacao);
        if ($notificacao["status"] == 1) {
            $contador_nao_lidas++;
        }
    }
    if($contador_nao_lidas>9){
        $contador_nao_lidas = "+9";
    }
    $stmt->close();
    $conexao->close();
    return ['notificacoes' => $lista_notificacoes, 'nao_lidas' => $contador_nao_lidas];
}
function notif_marcar_tudo_lido(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $sql = "UPDATE notificacao SET status = 0 WHERE usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->close();
    $conexao->close();
}
function notif_apagar_tudo(){
    $conexao = obterConexao();
    $email = $_SESSION["logado"];
    $sql = "DELETE FROM notificacao WHERE usuario = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->close();
    $conexao->close();
}
function cancelarEntrega($pedido){
    $conexao = obterConexao();
    $sql = "UPDATE pedido SET motorista = NULL, veiculo = NULL,  valor = NULL, status = 'Novo' WHERE id_p = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i",$pedido);
    $stmt->execute();
    $notificacao = "entrega_cancelada";
    notificacao($pedido,$notificacao);
    $stmt->close();
    $conexao->close();
}
?>