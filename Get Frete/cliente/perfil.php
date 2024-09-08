<?php include("../include/cabecalho_cliente.php");
buscarCliente();
$usuario = $_SESSION["usuario"];
$lista_pedidos = listarPedidos_cliente();
$lista_pedidos_conf = listarPedidos_conf_cliente();
$saudacao = saudacao();
$data_atual = date('Y/m/d');
$horario_atual = date('H:i:s');
$timestamp_atual = strtotime($data_atual.' '.$horario_atual);
?>
<div class="container">
    <div class="cabecalho">
        <div class="row">
            <div class="col">
            <div id="foto_perfil">
            <img src="<?=$usuario["imagem"]?>" alt="Foto de perfil de <?=$usuario["nome"]?>"/>
            </div>
            </div>
            <div class="col-md-auto">
            <h2><?php echo $usuario["nome"] . ' ' . $usuario["sobrenome"];?></h2>
            <p><span class="material-symbols-outlined">location_on</span> <?php echo $usuario["cidade"] . ' - ' . $usuario["uf"];?><p>
            <p><span class="material-symbols-outlined">call</span> <?php echo $usuario["telefone"]?><p>
            </div>
            <div class="col col-sm-auto">
            <a class="link-secondary" id="link" data-bs-toggle="modal" data-bs-target="#config"><span class="material-symbols-outlined">settings</span></a>
            </div>
        </div>    
    </div>
    <!--Modal de configurações-->
    <div class="modal fade" id="config" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="configLabel">Configurações</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <a class="link link-secondary" data-bs-toggle="modal" data-bs-target="#editar"><span class="material-symbols-outlined">stylus_note</span> Editar perfil</a><br>
            <a class="link-danger" id="link" onclick="alert_deletar()"><span class="material-symbols-outlined">delete</span> Excluir minha conta</a>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
        </div>
    </div>
    </div>
    <!--Modal de edição de perfil-->
    <div class="modal fade" id="editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="ediarLabel">Editar dados</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  enctype="multipart/form-data" action="editar_dados.php" method="post">
                <div class="textfield">
                    <label for="nome">Nome</label>
                    <input type="text" placeholder="Nome" id="nome" name="nome" value="<?php echo $usuario["nome"] ?>" required>
                </div>
                <div class="textfield">
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" placeholder="Sobrenome" id="sobrenome" name="sobrenome" value="<?php echo $usuario["sobrenome"] ?>" required>
                </div>
                <div class="textfield">
                    <label for="email">E-mail</label>
                    <input type="email" placeholder="E-mail" id="email" name="email" value="<?php echo $usuario["email"] ?>" style="cursor:not-allowed;" disabled required>
                    <p class="text-secondary text-center">O e-mail não pode ser alterado por questões de segurança.</p>
                </div>
                <div class="textfield">
                    <label for="senha">Senha</label>
                    <input type="password" placeholder="Senha" id="senha_ed" name="senha" onkeyup="validarSenhaEd()" value="<?php echo $_SESSION["senha"] ?>" required>
                    <p id="mensagem"></p>
                </div>
                <div class="textfield">
                    <label for="cpf">CPF</label>
                    <input type="text" placeholder="xxx.xxx.xxx-xx" id="cpf" name="cpf" maxlength="14" minlength="14" value="<?php echo $usuario["cpf"] ?>" required></br>
                </div>
                <div class="textfield">
                    <label for="telefone">Telefone</label>
                    <input type="text" placeholder="(xx) xxxxx-xxxx" id="telefone" name="telefone" maxlength="15" minlength="14" value="<?php echo $usuario["telefone"] ?>" required></br>
                </div>
                <div class="textfield">
                    <p>Localização: <?php echo $usuario["cidade"] . ' - ' . $usuario["uf"];?><br>
                    <input type="checkbox" id="localizacao" onchange="mostrarLocalizacao()">
                    <label for="localizacao"> Editar</label>
                    </p>
                        <div id="conteudo_localizacao" class="hidden">
                            <div class="textfield">
                            <label for="uf">UF</label>
                            <select name="uf" id="uf">
                                <option value="">Escolha...</option>
                            </select>
                            </div>
                            <div class="textfield">
                                <label for="cidade">Cidade</label>
                                <select name="cidade" id="cidade">
                                    <option value="">Escolha...</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="input-box">
                    <label for="perfil_img">Foto de perfil</label>
                    <div class="row">
                        <div class="col1 col-md-6">
                            <div id="foto_perfil">
                            <img src="<?=$usuario["imagem"]?>" alt="Foto de perfil de <?=$usuario["nome"]?>"/>
                            </div>
                        </div>
                        <div class="col2 col-md-6">
                        <label class="picture" for="perfil_img" tabIndex="0"><span class="perfil_img"></span></label>
                        <input type="file" accept="image/*" name="perfil_img" id="perfil_img" value=" <?php  $usuario["imagem"] ?>">
                        </div>
                    </div>
                    <p class="text-secondary text-center">Para manter a mesma foto de perfil não preencha o campo direito (quadrado).</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <input type="submit" value="Confirmar" id="btn_editar" onclick="return Erros()" class="btn btn-primary"/>
                </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="content">
<!--Início pedidos confirmados-->
<h4><span class="material-symbols-outlined">magic_button</span> Pedidos confirmados</h4>
    <?php
    if (empty($lista_pedidos_conf)) { 
        echo '<p class="text-secondary">Você não possui nenhum pedido confirmado</p>';
    } else {
        echo '<div id="pedidos">';
        foreach ($lista_pedidos_conf as $pedido) {
            $lista_propostas = listarPropostas($pedido["id_p"]);
            $data = formataData($pedido["data_entrega"]);
            $hora = formataHora($pedido["horario"]);
            ?>
            <div id="card_agenda">
                <h6><?php echo $pedido["descricao"]; ?></h6>
                <p><?php echo $data; ?> às <?php echo $hora?>h</p>
                <p><?php echo $pedido["motorista"]." | R$ ".$pedido["valor"]; ?></p>
                <p><a href="tel:<?php echo $pedido["telefone"]; ?>"><span class="material-symbols-outlined">call</span> <?php echo $pedido["telefone"]; ?></a></p>
                <button class="btn btn-secondary" id="botao_largo" data-bs-toggle="modal" data-bs-target="#modalpedido<?php echo $pedido["id_p"]?>_confirmado"><span class="material-symbols-outlined">expand_more</span> Ver detalhes</button>
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
                        <p><span class="material-symbols-outlined">calendar_month</span> <?php echo $data; ?> às <?php echo $hora?>h</p>
                        <p><span class="material-symbols-outlined">person_apron</span> Ajudante: <?php echo $pedido["ajudante"]; ?></p>
                        <?php
                        $timestamp_pedido = strtotime($pedido["data_entrega"] . ' ' . $pedido["horario"]);
                        $diferenca_segundos = $timestamp_pedido - $timestamp_atual;
                        $diferenca_horas = floor($diferenca_segundos/3600);
                        if($diferenca_horas>=24){?>
                            <form action="excluir_pedido.php" method="post" class="w-100">
                            <input type="hidden" name="id_p" value="<?php echo $pedido["id_p"]; ?>">
                            <button type="submit" class="btn btn-danger w-100 mt-2"><span class="material-symbols-outlined">delete</span> Excluir pedido</button>
                        </form>
                        <?php };?>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </form>
                    </div>
                    </div>
            </div>
            </div>
            <?php
        };
        echo '</div>';
    };
?>
<!--Fim dos pedidos confirmados-->
<!--Início pedidos novos-->
    <br>
    <h4>Aguardando propostas</h4>
    <?php
    if (empty($lista_pedidos)) { 
        echo '<p class="text-secondary">Você não possui nenhum pedido novo</p>
        <img src="../assets/img/interrogacao.png" alt="homem deitado relaxando" style="width:300px; padding:10px">';
    } else {
        echo '<div id="pedidos">';
        foreach ($lista_pedidos as $pedido) {
            $lista_propostas = listarPropostas($pedido["id_p"]);
            $data = formataData($pedido["data_entrega"]);
            $hora = formataHora($pedido["horario"]);
            ?>
            <div id="card_pedido">
                <img src="../assets/img/caixa_laranja.png" alt="ilustração de caixa" style="width:100px;"/>
                <h5><?php echo $pedido["descricao"]; ?></h5>
                <p class="text-secondary"><?php echo $pedido["categoria"]?></p>
                <p><span class="material-symbols-outlined">location_on</span> Retirada: <?php echo $pedido["origem"]; ?></p>
                <p><span class="material-symbols-outlined">where_to_vote</span> Entrega: <?php echo $pedido["destino"]; ?></p>
                <p><span class="material-symbols-outlined">calendar_month</span> <?php echo $data; ?> às <?php echo $hora?>h</p>
                <p><span class="material-symbols-outlined">person_apron</span> Ajudante: <?php echo $pedido["ajudante"]; ?></p>
                <button class="btn btn-secondary" id="botao_largo" data-bs-toggle="modal" data-bs-target="#modalpedido<?php echo $pedido["id_p"]?>"><span class="material-symbols-outlined">receipt_long</span> Ver propostas</button>
                <form action="excluir_pedido.php" method="post" class="w-100">
                        <input type="hidden" name="id_p" value="<?php echo $pedido["id_p"]; ?>">
                        <button type="submit" class="btn btn-danger w-100 mt-2"><span class="material-symbols-outlined">delete</span> Excluir pedido</button>
                </form>
                </div>
                <div class="modal fade" id="modalpedido<?php echo $pedido["id_p"]?>" tabindex="-1" aria-labelledby="modalpedidoLabel" data-bs-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalpedidoLabel">Propostas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div id="propostas">
                    <?php
                        if(empty($lista_propostas)){
                            echo '<div style="display:flex;flex-direction:column;align-items: center;"><p class="text-secondary">Esse pedido ainda não recebeu propostas</p>
                            <img src="../assets/img/deposito.png" alt="deposito com caixas" style="width:300px; padding:10px"></div>';
                        }else{
                            echo "Selecione uma oferta abaixo:";
                            foreach($lista_propostas as $proposta){
                            ?>
                            <form action="escolha_proposta.php" method="post">
                            <div id="proposta">
                            <input type="radio" id="<?php echo $proposta["id_pr"];?>" value="<?php echo $proposta["id_pr"]?>" name="proposta">
                            <label for="<?php echo $proposta["id_pr"];?>">
                            <h5>R$ <?php echo $proposta["valor"];?></h5>
                            <p><?php echo $proposta["motorista"]." - ".$proposta["avaliacao"];
                                if($proposta["viagens"]>=10){
                                    echo ' ('.$proposta["viagens"].' viagens)';
                                };?>
                            </p>
                            <p><?php echo $proposta["veiculo"]." | ".$proposta["telefone"];?></p>
                            <p>Aceita: <?php echo $proposta["pagamento"];?></p>
                            </label>
                            </div>
                            <?php
                            };
                        };
                    ?>
                    </div>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <input type="submit" class="btn btn-primary" value="Confirmar">
                        </form>
                    </div>
                </div>
                </div>    
            </div>
            <?php
        };
        echo '</div>';
    };
?>
<!--Fim dos pedidos novos-->
</div>
<?php include("../include/rodape_cliente.php");?>