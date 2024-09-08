<?php
    require("../database/funcoes.php");
    $proposta_escolhida = $_POST["proposta"];
    escolherProposta($proposta_escolhida);
    header("Location:perfil.php");
?>