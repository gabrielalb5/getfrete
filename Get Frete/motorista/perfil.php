<?php include("../include/cabecalho_motorista.php");
buscarUsuario();
buscarCNH();
buscarImagem();
$usuario = $_SESSION["usuario"];
$cnh = $_SESSION["cnh"];
$imagem = $_SESSION["imagem"];
?>
<div class="container">
    <div class="cabecalho">
        <div class="row">
            <div class="col col-lg-3">
            <div id="foto_perfil">
            <img src="<?=$imagem["path"]?>" alt="Foto de perfil de <?=$usuario["nome_social"]?>"/>
            </div>
            </div>
            <div class="col-md-auto">
            <h2><?php echo $usuario["nome"] . ' ' . $usuario["sobrenome"];?></h2>
            <p><span class="material-symbols-outlined">location_on</span> <?php echo $usuario["cidade"] . ' - ' . $usuario["uf"];?><p>
            <p><span class="material-symbols-outlined">call</span> <?php echo $usuario["telefone"]?><p>
            <p><span class="material-symbols-outlined">magic_button</span> Avaliação: 0.0</p>
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editar">Editar perfil</button>
            </div>
            <div class="col-md-auto" style="margin:10px;">
            <h5>Veículos</h5>
            <p>Não há veículos cadastrados</p>
            <img src="../assets/img/veiculo.png" alt="imagem de veículo" style="width:135px; padding:10px">
            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#veiculo">Adicionar veículo</button>
            <?php
            //buscarVeiculo();
            ?>
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
            <h1 class="modal-title fs-5" id="ediarLabel">Editar perfil</h1>
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
                    <label for="nome_social">Nome social</label>
                    <input type="text" placeholder="Como você gostaria de ser chamado?" id="nome_social" name="nome_social" value="<?php echo $usuario["nome_social"] ?>" required>
                </div>
                <div class="textfield">
                    <label for="email">E-mail</label>
                    <input type="email" placeholder="E-mail" id="email" name="email" value="<?php echo $usuario["email"] ?>" disabled required>
                    <p class="text-secondary text-center">O e-mail não pode ser alterado por questões de segurança.</p>
                </div>
                <div class="textfield">
                    <label for="senha">Senha</label>
                    <input type="password" placeholder="Senha" id="senha" name="senha" onkeyup="validarSenha()" value="<?php echo $_SESSION["senha"] ?>" required>
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
                    <label for="uf">UF</label>
                    <select name="uf" id="uf" required>
                        <option value="">Escolha...</option>
                    </select>
                </div>
                <div class="textfield">
                    <label for="cidade">Cidade</label>
                    <select name="cidade" id="cidade" required>
                        <option value="">Escolha...</option>
                    </select>
                </div>
                <div class="input-box">
                    <label for="perfil_img">Foto de perfil</label>
                    <div class="row">
                        <div class="col1 col-md-6">
                            <div id="foto_perfil">
                            <img src="<?=$imagem["path"]?>" alt="Foto de perfil de <?=$usuario["nome_social"]?>"/>
                            </div>
                        </div>
                        <div class="col2 col-md-6">
                        <label class="picture" for="perfil_img" tabIndex="0"><span class="perfil_img"></span></label>
                        <input type="file" accept="image/*" name="perfil_img" id="perfil_img" value=" <?php  $imagem["path"] ?>">
                        </div>
                    </div>
                    <p class="text-secondary text-center">Para manter a mesma foto de perfil não preencha o campo direito (quadrado).</p>
                </div>
                <div class="textfield">
                    <label for="numero_cnh">CNH</label>
                    <input type="text" placeholder="XXX.XXX.XXX-XX" id="numero_cnh" name="numero_cnh" maxlength="14" minlength="14" value="<?php echo $cnh["numero"] ?>" disabled required>
                    <p class="text-secondary text-center">A CNH não pode ser alterada por questões de segurança.</p>
                </div>
                <div class="textfield">
                    <label for="validade_cnh">Validade da CNH</label>
                    <input type="date" id="validade_cnh" name="validade_cnh" value="<?php echo $cnh["validade"] ?>" required></br>
                </div>
                <div class="input-box">
                    <label for="cnh_img">Foto da CNH</label>
                    <label class="picture" id="cnh_preview" for="cnh_img" tabIndex="0"><span class="cnh_img"></span></label>
                    <input type="file" accept="image/*" name="cnh_img" id="cnh_img">
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
<?php include("../include/rodape.php");?>