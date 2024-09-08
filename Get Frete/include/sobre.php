<div id="sobre">
<div id="container">
    <h3>Sobre o Get Frete</h3>
    <div id="introducao">
        <p id="texto">O Get Frete é uma plataforma para aqueles que buscam serviços de frete.
                Através dela você pode realizar entregas ou solicitá-las. O projeto surgiu em 2023 idealizado
                com o objetivo de atender necessidades advindas da informalidade do serviço, como a dificuldade
                de encontrar motoristas, por exemplo.
        </p>
        <div id="espaco" class="p-3"></div>
        <img id="gif" src="../assets/img/img_sobre.gif" alt="Animação com ilustrações">
    </div>
    <h3>Ajuda</h3>
    <div id="accordion">
        <div class="card" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <div class="card-header" id="headingOne">
            <h6 class="p-1 mb-0">Cadastro</h6>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
            <p>Para a utilização do sistema é necessário cirar uma conta em "Cadastre-se". Você pode escolher entre
                dois tipos de perfil: cliente ou motorista. Em suma, o cliente faz solicitações de entregas, 
                enquanto o motorista recebe esses pedidos. Uma conta possui vínculo apenas com um tipo de perfil.
            </p>
            <p>É necessário preencher todos os dados solicitados antes de prosseguir e ao 
                finalizar o cadastro você poderá acessar seu perfil em "Entrar" e explorar o Get Frete.</p>
            </div>
        </div>
        </div>
        <div class="card" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <div class="card-header" id="headingTwo">
            <h6 class="p-1 mb-0">Cliente</h6>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
            <div class="card-body">
            <h6>Realizando pedido</h6>
            <p>Preencha todos os dados do formulário na página inicial como solicitado. Após o envio, o pedido 
                estará sujeito a receber propostas de motoristas da região. Seu novo pedido será exibido na seção "Aguardando proposta" em "Perfil".
            </p>
            <h6>Escolhendo propostas</h6>
            <p>Para escolher uma proposta clique no botão "Ver propostas" e selecione uma delas. Após confirmar, o motorista será notificado 
            - você também pode entrar em contato com o mesmo através de seu telefone - e o pedido passará a ser exibido na seção "Pedidos confirmados" em "Perfil".
            </p>
            <h6>Avaliação</h6>
            <p>Quando uma entrega é finalizada, é necessário avaliá-la em "Ínicio". A escala de avaliação varia 
                desde "Ruim" até "Ótima". Não é possível realizar novos pedidos enquanto as entregas finalizadas não forem avaliadas.
            </p>
            <h6>Cancelando pedido</h6>
            <p>O cancelamento de pedido só é permitido quando:
                <ol>
                    <li>Estiver aguardando propostas;</li>
                    <li>Restarem 24h ou mais para o prazo final da entrega de um pedido confirmado.</li>
                </ol>
            </p>
            </div>
        </div>
        </div>

        <div class="card" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <div class="card-header" id="headingThree">
            <h6 class="p-1 mb-0">Motorista</h6>
        </div>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
            <div class="card-body">
            <h6>Veículos</h6>
            <p>Ao acessar sua conta pela primeira vez uma mensagem será exibida requisitando o cadastro de um veículo. 
                Você pode vincular até três veículos à sua conta. Ao clicar em "Adicionar veículo" ou apenas "Adicionar" na seção 
                "Veículos" em "Perfil" um formulário será exibido e todos os dados devem ser preenchidos como solicitado.
            </p>
            <p>Alguns dados do veículo podem ser editados no botão "Editar" na seção "Veículos" em "Perfil". Um veículo só pode ser excluído 
            quando não estiver fazendo parte de algum pedido pendente.
            </p>
            <h6>Propostas</h6>
            <p>Na página incial, pedidos serão exibidos de acordo com sua localização cadastrada. 
                Para enviar propostas clique no botão "Fazer proposta", sugira um valor e escolha um veículo. Após enviada, a proposta será exibida 
                na seção "Propostas enviadas" em "Perfil". Não é possível editar, mas ao excluir, o pedido voltará a ser exibido em "Ínicio" 
                estando sujeito a uma outra proposta.
            </p>
            <h6>Entregas agendadas</h6>
            <p>Quando a proposta é aceita pelo cliente o pedido passa a ser exibido na seção "Entregas agendadas" em "Perfil".
            </p>
            <h6>Iniciando e finalizando entrega</h6>
            <p>A entrega com o prazo mais próximo é exibida em "Ínicio" juntamente de um contador. Só é possível iniciá-la quando o contador indicar menos de 24h. 
                Ao clicar em "Iniciar entrega" um mapa com a rota da entrega e todos os detalhes do pedido serão exibidos. Não será possível visualizar pedidos novos até a finalização da entrega.
            </p>
            <h6>Avaliação</h6>
            <p>Sua avaliação depende de seu desempenho nas entregas. Ao iniciar você recebe o selo de "Novato" e a partir de dez entregas ganha uma média de todas 
                as notas. Sua nota e quantidade de entregas são exibidas para clientes ao escolher uma proposta, por exemplo.
            </p>
            </div>
        </div>
        </div>

        <div class="card" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        <div class="card-header" id="headingFour">
            <h6 class="p-1 mb-0">Histórico</h6>
        </div>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
            <div class="card-body">
            <p>
                O histórico contém todos os dados dos pedidos e entregas, solicitados por clientes ou realizados por motoristas. 
                Outros usuários não podem acessar seu histórico. Um pedido só é considerado finalizado de fato quando adicionado ao histórico, 
                ou seja, após a avaliação do cliente.
            </p>
            </div>
        </div>
        </div>
        <div class="card" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
            <div class="card-header" id="headingFive">
                <h6 class="p-1 mb-0">Perfil ou Conta</h6>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                <div class="card-body">
                    <p>Ao acessar sua conta, seus dados serão exibidos em "Perfil".</p>
                    <h6>Editar perfil</h6>
                    <p>Ao clicar no ícone de configurações <span style="margin-left: -30px" class="material-symbols-outlined">settings</span> em "Perfil", 
                    escolha "Editar perfil" e altere seus dados como desejar, com exceção do e-mail que não pode ser alterado.</p>
                    <h6>Excluir conta</h6>
                    <p>Ao clicar no ícone de configurações <span style="margin-left: -30px" class="material-symbols-outlined">settings</span> em "Perfil",
                    escolha "Excluir minha conta". Não será possível recuperá-la e essa ação só pode ser realizada quando não houverem pedidos pendentes.
                    </p>
                    <h6>Esqueci minha senha</h6>
                    <p>Caso tenha esquecido a senha, você poderá solicitar sua alteração através do link "Esqueci minha senha" na seção "Entrar". 
                        Informe o e-mail cadastrado no formulário e envie. Se a conta existir enviaremos uma mensagem por e-mail com as instruções para alteração de senha. 
                        O link enviado é válido apenas para uma única alteração. Caso esqueça novamente, solicite outro link.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="d-flex justify-content-center align-items-center flex-column">
    <p>Possui dúvidas, sugestões ou precisa de ajuda? Envie um e-mail para <a href="mailto:getfrete@gmail.com">getfrete@gmail.com</a></p>
    </div>
    <br>
    <h3>Conheça o time</h3>
    <div id="time">
        <div class="badge-base LI-profile-badge" data-locale="pt_BR" data-size="medium" data-theme="light" data-type="VERTICAL" data-vanity="gabrielalbino05" data-version="v1"><a class="badge-base__link LI-simple-link" href="https://br.linkedin.com/in/gabrielalbino05?trk=profile-badge"></a></div>
        <div class="badge-base LI-profile-badge" data-locale="pt_BR" data-size="medium" data-theme="light" data-type="VERTICAL" data-vanity="lívia-siqueira-galli" data-version="v1"><a class="badge-base__link LI-simple-link" href="https://br.linkedin.com/in/lívia-siqueira-galli?trk=profile-badge"></a></div>
    </div>
</div>
</div>