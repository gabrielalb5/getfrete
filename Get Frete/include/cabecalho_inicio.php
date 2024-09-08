<?php require("../database/funcoes.php");
require("../util/mensagens.php");
if(isset($_SESSION["logado"])){logado();};?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Gabriel Albino & Lívia Galli">
    <title>Get Frete</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png">
</head>
<body>
  <header>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top">
    <a class="navbar-brand" href="../public/index.php"><img src="../assets/img/logowhite.png" alt="GET FRETE" class="logo"></a>
    <a href="#" class="toggle-button"><span class="material-symbols-outlined">menu</span></a>
    <div class="navbar-nav navbar-links">
      <a class="nav-item nav-link" href="../public/index.php">Entrar</a>
      <a class="nav-item nav-link" href="../public/cadastro.php">Cadastre-se</a>
      <a class="nav-item nav-link" href="../public/sobre.php">Sobre e Ajuda</a>
    </div>
    </nav>
    <div class="espacamento"></div>
    <?php exibir_msg(); ?>
  </header>
  <main>