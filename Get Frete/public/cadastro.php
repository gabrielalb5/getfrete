<?php include("../include/cabecalho_inicio.php");?>
<div id="titulo">
  <h2>Cadastro</h2>
  <p>Escolha seu perfil de usuário</p>
</div>
<div class="main-cadastro">
  <div id="left-cadastro" onclick="red_cad_cliente()">
    <h3>Cliente</h3>
    <p>Faça pedidos de transporte</p>
    <img src="../assets/img/cliente.png" alt="Ilustração de cliente." class="cliente">
  </div>
  <div id="right-cadastro" onclick="red_cad_motorista()">
    <h3>Motorista</h3>
    <p>Receba pedidos e entregue</p>
    <img src="../assets/img/motorista.png" alt="Ilustração de motorista." class="motorista">
  </div>
</div>
<?php include("../include/rodape_inicio.php");?>