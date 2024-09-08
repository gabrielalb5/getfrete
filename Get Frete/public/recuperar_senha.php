<?php
    require("../database/funcoes.php");
    $email = $_POST["email"];
    emailExiste($email);
    header("Location:index.php");
?>