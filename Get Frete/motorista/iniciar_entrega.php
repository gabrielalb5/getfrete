<?php
    require("../database/funcoes.php");
    $id_p = $_POST["id_p"];
    iniciarEntrega($id_p);
    header("Location:inicio.php");
?>