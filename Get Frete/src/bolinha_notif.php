<?php require("../database/funcoes.php");
$resultado = listar_notificacoes();
$cont_nao_lidas = $resultado['nao_lidas'];
if($cont_nao_lidas!=0){ ?>
<p id="bolinha_notificacao"><?php echo $cont_nao_lidas?></p>
<?php };?>