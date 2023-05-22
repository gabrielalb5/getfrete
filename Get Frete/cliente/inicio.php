<?php include("../include/cabecalho_cliente.php");
buscarUsuario();
$saudacao = saudacao();
//var_dump($_SESSION["usuario"]);?>
<div class="container">
    <h2><?php echo $saudacao?></h2>
</div>
<?php include("../include/rodape.php");?>