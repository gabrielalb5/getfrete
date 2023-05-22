<?php require("../database/funcoes.php");
require("../util/mensagens.php");
deslogado();?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Gabriel Albino & Lívia Galli">
    <title>Get Frete</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png">
</head>
<body>
  <header>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top">
    <a class="navbar-brand" href="../public/index.php"><img src="../assets/img/logowhite.png" alt="GET FRETE" class="logo"></a>
    <a href="#" class="toggle-button"><span class="material-symbols-outlined">menu</span></a>
    <div class="navbar-nav navbar-links">
      <a class="nav-item nav-link" href="../motorista/inicio.php">Início</a>
      <a class="nav-item nav-link" href="../motorista/perfil.php">Perfil</a>
      <a class="nav-item nav-link" href="../src/logout.php"><span class="material-symbols-outlined">logout</span> Sair</a>
    </div>
    </nav>
    <div class="espacamento"></div>
    <?php exibir_msg(); ?>
  </header>
  <main>