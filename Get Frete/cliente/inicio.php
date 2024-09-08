<?php include("../include/cabecalho_cliente.php");
buscarCliente();
$saudacao = saudacao();
$lista_cp = listarCategoriaPedido();
$lista_avaliacao = status_avaliacao();?>
<div class="container">
    <div class="saudacao">
    <h2><?php echo $saudacao?></h2><br>
    </div>
    <?php if(!empty($lista_avaliacao)){ ?>
    <h4 class="text-secondary">Avalie antes de realizar novos pedidos</h4>
    <?php }; ?>
    <div id="avaliacoes">
    <?php 
        foreach($lista_avaliacao as $pedido){
            $data = formataData($pedido["data_entrega"]);
            $hora = formataHora($pedido["horario"]);?>
        <div id="card_avaliacao">
                <h6>Como você avalia a entrega de <?php echo $pedido["motorista"] ?>?</h6>
                <form action="avaliacao_pedido.php" method="post" class="w-100">
                <div id="texto" class="d-flex justify-content-between m-0">
                    <p>Ruim</p>
                    <input type="range" name="avaliacao" class="form-range w-50" min="1" max="5">
                    <p>Ótima</p>
                </div>
                <p class="text-secondary"><?php echo $pedido["descricao"] ?> - <?php echo $data; ?> às <?php echo $hora;?>h</p>
                    <input type="hidden" value="<?php echo $pedido["id_p"] ?>" name="id_p">
                    <button class="btn mt-0" id="btn_azul">Avaliar</button>
                </form>
                <button class="btn btn-white mt-1" id="botao_largo" data-bs-toggle="modal" data-bs-target="#modalpedido<?php echo $pedido["id_p"]?>_confirmado"><span class="material-symbols-outlined">expand_more</span> Ver detalhes</button>
        </div>
        <div class="modal fade" id="modalpedido<?php echo $pedido["id_p"]?>_confirmado" tabindex="-1" aria-labelledby="modalpedidoLabel" data-bs-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalpedidoLabel">Detalhes</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5><?php echo $pedido["descricao"]; ?></h5>
                        <p class="text-secondary"><?php echo $pedido["categoria"]?></p>
                        <p><span class="material-symbols-outlined">badge</span> <?php echo $pedido["motorista"]; ?></p>
                        <p><a href="tel:<?php echo $pedido["telefone"]; ?>"><span class="material-symbols-outlined">call</span> <?php echo $pedido["telefone"]; ?></a></p>
                        <p><span class="material-symbols-outlined">directions_car</span> <?php echo $pedido["tipo_veiculo"].' - '.$pedido["placa"]; ?></p>
                        <p><span class="material-symbols-outlined">payments</span> R$ <?php echo $pedido["valor"].' - '.$pedido["pagamento"]; ?></p>
                        <p><span class="material-symbols-outlined">location_on</span> Retirada: <?php echo $pedido["origem"]; ?></p>
                        <p><span class="material-symbols-outlined">where_to_vote</span> Entrega: <?php echo $pedido["destino"]; ?></p>
                        <p><span class="material-symbols-outlined">calendar_month</span> <?php echo $data; ?> às <?php echo $hora; ?>h</p>
                        <p><span class="material-symbols-outlined">person_apron</span> Ajudante: <?php echo $pedido["ajudante"]; ?></p>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                    </div>
            </div>
            </div>
    <?php };
    ?>
    </div>
    <?php
    if(empty($lista_avaliacao)){?>
    <div id="form_pedido">
    <h4>O que você precisa transportar?</h4>
    <p class="text-secondary">Veja seus pedidos em <a href="perfil.php">Perfil</a></p>
    <form action="pedido.php" method="post">
    <div id="colunas">
        <div id="col1">
            <div class="textfield">
                <label for="descricao">Descrição</label>
                <input type="text" placeholder="O que será transportado?" id="descricao" name="descricao" required>
            </div>
            <div class="textfield">
                <label for="origem">Endereço de retirada</label>
                <input type="text" placeholder="Rua/Av., número, cidade e estado" id="origem" name="origem" required>
            </div>
            <div class="textfield">
                <label for="destino">Endereço de entrega</label>
                <input type="text" placeholder="Rua/Av., número, cidade e estado" id="destino" name="destino" required>
            </div>
        </div>
        <div id="col2">
            <div class="textfield">
                <label for="categoria">Categoria</label>
                <select name="categoria" id="categoria" required>
                    <option value="">Escolha...</option>
                    <?php foreach ($lista_cp as $categoria) : ?>
                        <option value='<?=$categoria["id_cp"]?>'>
                        <?=$categoria["nome"]?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="textfield">
                <label for="data_min">Quando?</label>
                <input type="date" id="data_min" name="data_entrega" required>
            </div>
            <div class="textfield">
                <label for="horario">Horário</label>
                <input type="time" id="horario" name="horario" required>
            </div>
        </div>
    </div>
    <div id="opcao_login">
                <p>Precisa de ajudante?</p>
                <input type="radio" id="0" value="0" name="ajudante" required>
                <label for="0">Não</label>
                <input type="radio" id="1" value="1" name="ajudante">
                <label for="1">Sim</label>
            </div>
    <div class="d-flex justify-content-center align-items-center flex-column">
    <p class="text-secondary">Ao enviar o pedido não será possível editá-lo.<br>Você será notificado ao receber propostas.</p>
    <div class="form-check">
    <input type="checkbox" id="concordo" required>
    <label for="concordo"> Entendi e desejo prosseguir</label>
    </div>
    </div>
    <input type="submit" class="btn" id="btn_azul" value="Enviar pedido"><br>
    </form>
    </div>
    <?php }; ?>
</div>
<?php include("../include/rodape_cliente.php");?>