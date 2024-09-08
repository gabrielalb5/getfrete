<?php
include("../include/cabecalho_cliente.php");
buscarCliente();
$usuario = $_SESSION["usuario"];
$email = $usuario["email"];
$pagina = 1;
if(isset($_GET["pagina"])){
    $pagina = filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT);
};
if(!$pagina){
    $pagina = 1;
};
$limite = 10;
$inicio = ($pagina*$limite) - $limite;
$lista_historico = historico($inicio,$limite);

$con = new PDO("mysql:host=localhost;dbname=getfrete","web","web");
$registros = $con->query("SELECT COUNT(id_h) count FROM historico WHERE email_c = '$email'")->fetch()["count"];
$paginas = ceil($registros/$limite);
?>
<br>
<div id="tabela_historico">
<?php
if (empty($lista_historico)) {
    echo '<h4>Histórico</h4><p class="text-secondary">Você não possui pedidos finalizados</p>';
} else {
    ?>
    <table class="table table-hover w-75">
        <thead id="historico">
            <tr class="text-center">
                <th colspan="5">Histórico</th>
            </tr>
            <tr class="text-center bg-light text-dark">
                <th>Data e horário</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Detalhar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($lista_historico as $pedido) {
                $data = formataData($pedido['data_entrega']);
                $hora = formataHora($pedido['horario']);
                echo "<tr class='text-center'>";
                echo "<td>" .$data.' às '.$hora.'h'. "</td>";
                echo "<td>" . $pedido['descricao'] . "</td>";
                echo "<td>R$ " . $pedido['valor'] . "</td>";?>
                <td><button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalhistorico<?php echo $pedido["id_pedido"]?>"><span class="material-symbols-outlined">expand_more</span></td>
        <?php   echo "</tr>";?>
            <!--modal de cada entrega/pedido do histórico-->
                <div class="modal fade" id="modalhistorico<?php echo $pedido["id_pedido"]?>" tabindex="-1" aria-labelledby="modalpedidoLabel" data-bs-backdrop="static" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalhistoricoLabel">Detalhes</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Pedido #<?php echo $pedido["id_pedido"];?></h5>
                            <p><span class="material-symbols-outlined">package_2</span> <?php echo $pedido["descricao"]; ?></p>
                            <p><span class="material-symbols-outlined">badge</span> <?php echo $pedido["motorista"]; ?> <span class="material-symbols-outlined">calendar_month</span> <?php echo $data; ?> às <?php echo $hora; ?>h</p>
                            <p><span class="material-symbols-outlined">location_on</span> Retirada: <?php echo $pedido["origem"]; ?></p>
                            <p><span class="material-symbols-outlined">where_to_vote</span> Entrega: <?php echo $pedido["destino"]; ?></p>
                            <p><span class="material-symbols-outlined">payments</span> R$ <?php echo $pedido["valor"];?> <span class="material-symbols-outlined">person_apron</span> Ajudante: <?php echo $pedido["ajudante"]; ?></p>
                            <p><span class="material-symbols-outlined">directions_car</span> <?php echo $pedido["veiculo"]?></p>
                            <p>Finalizado em <?php echo arrayDataHora($pedido["finalizado"]);?></p>
                            <p>Essa entrega recebeu a avaliação <?php echo $pedido["avaliacao"];?><span class="material-symbols-outlined">magic_button</span></p>
                            <p>Entre em contato com o motorista <a href="tel:<?php echo $pedido["tel_m"]; ?>"><?php echo $pedido["tel_m"] ?></a></p>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            <?php
            };
            ?>
        </tbody>
    </table>
    <nav id="nav_historico">
    <ul class="pagination justify-content-center">
            <li class="page-item">
            <a class="page-link" href="?pagina=1" tabindex="-1">Primeira</a>
            </li>
            <?php if(!($pagina-1)==0){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?=$pagina-1?>"><?=$pagina-1?></a></li>
            <?php }; ?>
            <li class="page-item active"><a class="page-link" href="?pagina=<?=$pagina?>"><?=$pagina?></a></li>
            <?php if($paginas>$pagina){ ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?=$pagina+1?>"><?=$pagina+1?></a></li>
            <?php }; ?>
            <li class="page-item">
            <a class="page-link" href="?pagina=<?=$paginas?>">Última</a>
            </li>
        </ul>
    </nav>
<?php
};
?>
</div>
<?php include("../include/rodape_cliente.php")?>