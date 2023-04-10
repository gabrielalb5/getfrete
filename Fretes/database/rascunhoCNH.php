<?php
//Cadastro de CNH
function cadastrarCNH(){
    $cnh = $_SESSION;
    $sql = "INSERT INTO cnh (numero,validade,email) VALUES (?, ?, ?)";
    $conexao = obterConexao();
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("idi", $cnh["id_cnh"], $cnh["validade"], $cnh["email"]);
    $stmt->execute();
    $stmt->close();
    $conexao->close();
}
?>