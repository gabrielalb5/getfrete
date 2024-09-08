<?php header("Refresh: 60");
include("../include/cabecalho_motorista.php");
buscarMotorista();
$usuario = $_SESSION["usuario"];
$lista_tv = listarTipoVeiculo();
$lista_veiculos = listarVeiculos();
$contador_v = $_SESSION["veiculo_cont"];
$cidade = $_SESSION["usuario"]["cidade"];
$uf = $_SESSION["usuario"]["uf"];
$lista_pedidos = listarPedidos_motorista($cidade,$uf);
$lista_pedidos_conf = listarPedidos_conf_motorista();
$saudacao = saudacao();
$proxima_entrega = proximaEntrega();
$entrega_iniciada = entregaIniciada();
$diferenca_minutos = 1;
if(!empty($proxima_entrega)){
    $data_atual = date('Y/m/d');
    $horario_atual = date('H:i:s');
    $timestamp_atual = strtotime($data_atual.' '.$horario_atual);
    $timestamp_proxima_entrega = strtotime($proxima_entrega["data_entrega"] . ' ' . $proxima_entrega["horario"]);
    $diferenca_segundos = $timestamp_proxima_entrega - $timestamp_atual;
    $diferenca_minutos = floor($diferenca_segundos / 60);
    $diferenca_horas = floor($diferenca_segundos / 3600);
}
?>
<div class="container">
    <div class="saudacao">
    <h2><?php echo $saudacao?></h2>
    <?php
        if($contador_v==0){
            echo '<h4 class="text-secondary">Ação necessária na conta</h4>
            <a href="perfil.php"><button type="button" class="btn btn-secondary">Adicionar veículo</button></a></div>';
        }else{
            //verificador da próxima entrega (horário e atraso)
            if(!empty($lista_pedidos_conf) && !empty($proxima_entrega) && empty($entrega_iniciada)){
            $data = formataData($proxima_entrega["data_entrega"]);
            $hora = formataHora($proxima_entrega["horario"]);
            if($diferenca_minutos<=0){?>
                <p class="text-danger">Entrega de "<?php echo $proxima_entrega["descricao"]; ?>" atrasada</p>
                <p class="text-danger"><?php echo $data; ?> às <?php echo $hora; ?>h</p>
            <?php
            }else if($diferenca_horas<1){?>
                <p class="text-danger">Próxima entrega de "<?php echo $proxima_entrega["descricao"]; ?>" em <?php echo $diferenca_minutos; ?>min</p>
                <p class="text-danger"><?php echo $data; ?> às <?php echo $hora; ?>h</p>
            <?php
            }else{?>
                <p class="text-secondary">Próxima entrega de "<?php echo $proxima_entrega["descricao"]; ?>" em <?php echo $diferenca_horas; ?>h</p>
                <p class="text-secondary"><?php echo $data; ?> às <?php echo $hora; ?>h</p>
            <?php
            };?>
            <!--Formulário para iniciar entrega-->
            <?php
            if($diferenca_horas<24){?>
            <form action="iniciar_entrega.php" method="post">
                <input type="hidden" value="<?php echo $proxima_entrega["id_p"]; ?>" name="id_p">
                <button class="btn btn-secondary">Iniciar entrega</button>
            </form>
            <br>
        <?php
            };
            };
        if(empty($entrega_iniciada)){
            if (empty($lista_pedidos)) { 
                echo '<h4 class="text-secondary">Não há pedidos disponíveis</h4></div>'?>
                <p class="text-secondary">Veja propostas já enviadas em <a href="perfil.php">Perfil</a></p>
                <img src="../assets/img/relaxado.png" alt="homem deitado relaxando" style="width:300px; padding:10px">
            <?php
            }else{
            echo '<h4>Novos pedidos</h4></div>';
            echo '<p class="text-secondary">Veja propostas já enviadas em <a href="perfil.php">Perfil</a></p>';
            echo '<div id="pedidos">';
            $i = 0;
            foreach ($lista_pedidos as $pedido) {
                $data = formataData($pedido["data_entrega"]);
                $hora = formataHora($pedido["horario"]);
            ?>
                <div id="card_pedido" class="col-6">
                    <img src="../assets/img/caixa.png" alt="ilustração de caixa" style="width:100px;"/>
                    <h5><?php echo $pedido["descricao"]; ?></h5>
                    <p class="text-secondary"><?php echo $pedido["categoria"]?></p>
                    <p><span class="material-symbols-outlined">location_on</span> Retirada: <?php echo $pedido["origem"]; ?></p>
                    <p><span class="material-symbols-outlined">where_to_vote</span> Entrega: <?php echo $pedido["destino"]; ?></p>
                    <p><span class="material-symbols-outlined">calendar_month</span> <?php echo $data; ?> às <?php echo $hora?>h</p>
                    <p><span class="material-symbols-outlined">person_apron</span> Ajudante: <?php echo $pedido["ajudante"]; ?></p>
                    <button class="btn btn-secondary" id="botao_largo" data-bs-toggle="modal" data-bs-target="#modalproposta<?php echo $pedido["id_p"]?>"><span class="material-symbols-outlined">attach_money</span> Fazer proposta</button>
                </div>
                <div class="modal fade" id="modalproposta<?php echo $pedido["id_p"]?>" tabindex="-1" aria-labelledby="modalpropostaLabel" data-bs-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalpropostaLabel">Faça sua proposta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <h5><?php echo $pedido["descricao"]; ?></h5>
                    <p class="text-secondary"><span class="material-symbols-outlined">package_2</span> <?php echo $pedido["categoria"]?></p>
                    <p class="text-secondary"><span class="material-symbols-outlined">location_on</span> Retirada: <?php echo $pedido["origem"]; ?></p>
                    <p class="text-secondary"><span class="material-symbols-outlined">where_to_vote</span> Entrega: <?php echo $pedido["destino"]; ?></p>
                    <p class="text-secondary"><span class="material-symbols-outlined">calendar_month</span> <?php echo $data; ?> às <?php echo $hora;?>h</p>
                    <p class="text-secondary"> <span class="material-symbols-outlined">person_apron</span> Ajudante: <?php echo $pedido["ajudante"]; ?></p>
                    <form action="proposta.php" method="post">
                        <input type="hidden" name="pedido" value="<?php echo $pedido["id_p"] ?>">
                        <div class="textfield">
                        <label for="valor<?php echo $pedido["id_p"] ?>">Valor</label>
                        <input type="number" placeholder="Proponha uma oferta" id="valor<?php echo $pedido["id_p"] ?>" name="valor" min="0" max="99999999.99" step=".01" required></br>
                        </div>
                        <label for="veiculo<?php echo $pedido["id_p"] ?>">Veículo</label>
                        <select name="veiculo" id="veiculo<?php echo $pedido["id_p"] ?>" required>
                        <option value="">Escolha...</option>
                        <?php foreach ($lista_veiculos as $veiculo) : ?>
                            <option value='<?=$veiculo["renavam"]?>'>
                            <?=$veiculo["tipo"].' - '.$veiculo["placa"]?>
                            </option>
                        <?php endforeach ?>
                        </select>
                        <p class="text-secondary">Ao confirmar não será possível editar sua proposta.<br>Você será notificado caso seja escolhido.</p>
                        <input type="checkbox" id="concordo<?php echo $pedido["id_p"] ?>" required>
                        <label for="concordo<?php echo $pedido["id_p"] ?>">Entendi e desejo prosseguir</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value="Confirmar">
                        </div>
                        </div>
                    </form>
                </div>
                </div>    
            <?php };
            echo '</div>';
            };
        }else{
            $data = formataData($entrega_iniciada["data_entrega"]);
            $hora = formataHora($entrega_iniciada["horario"]);
            ?>
        <br>
        <div id="form_pedido">
            <p>Entrega de "<?php echo $entrega_iniciada["descricao"]; ?>" para <?php echo $entrega_iniciada["cliente"]; ?></p>
            <p><?php echo $data; ?> às <?php echo $hora ?>h</p>
            <p id="origem_mapa" value="<?php echo $entrega_iniciada["origem"]; ?>"><span class="material-symbols-outlined">location_on</span> A - Retirada: <?php echo $entrega_iniciada["origem"]; ?></p>
            <p id="destino_mapa" value="<?php echo $entrega_iniciada["destino"]; ?>"><span class="material-symbols-outlined">where_to_vote</span> B - Entrega: <?php echo $entrega_iniciada["destino"]; ?></p>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalpedido"><span class="material-symbols-outlined">expand_more</span> Ver detalhes</button>
            <br><div id="map"></div>
            <br>
            <form action="finalizar_entrega.php" method="post" class="w-100">
                <input type="hidden" value="<?php echo $entrega_iniciada["id_p"]; ?>" name="id_p">
                <div class="d-flex justify-content-center align-items-center flex-column">
                    <p class="text-secondary">Ao finalizar a entrega eu indico que o pedido chegou ao destino e eu recebi o valor combinado de R$ <?php echo $entrega_iniciada["valor"]?></p>
                    <div class="form-check">
                        <input type="checkbox" id="concordo" required>
                        <label for="concordo"> Entendi e desejo prosseguir</label>
                    </div>
                </div>
                <button class="btn mt-0" id="btn_azul"><span class="material-symbols-outlined">done</span> Finalizar entrega</button>
            </form>
        </div>
        <div class="modal fade" id="modalpedido" tabindex="-1" aria-labelledby="modalpedidoLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalpedidoLabel">Detalhes</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5><?php echo $entrega_iniciada["descricao"]; ?></h5>
                    <p class="text-secondary"><?php echo $entrega_iniciada["categoria"]?></p>
                    <p><span class="material-symbols-outlined">person</span> <?php echo $entrega_iniciada["cliente"]; ?></p>
                    <p><a href="tel:<?php echo $entrega_iniciada["telefone"]; ?>"><span class="material-symbols-outlined">call</span> <?php echo $entrega_iniciada["telefone"]; ?></a></p>
                    <p><span class="material-symbols-outlined">directions_car</span> <?php echo $entrega_iniciada["tipo_veiculo"].' - '.$entrega_iniciada["placa"]; ?></p>
                    <p><span class="material-symbols-outlined">payments</span> R$ <?php echo $entrega_iniciada["valor"].' - '.$usuario["pagamentos"]; ?></p>
                    <p><span class="material-symbols-outlined">location_on</span> Retirada: <?php echo $entrega_iniciada["origem"]; ?></p>
                    <p><span class="material-symbols-outlined">where_to_vote</span> Entrega: <?php echo $entrega_iniciada["destino"]; ?></p>
                    <p><span class="material-symbols-outlined">calendar_month</span> <?php echo $data; ?> às <?php echo $hora; ?>h</p>
                    <p><span class="material-symbols-outlined">person_apron</span> Ajudante: <?php echo $entrega_iniciada["ajudante"]; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
        </div>
        <?php };
        };?>
</div>
<?php include("../include/rodape_motorista.php");?>