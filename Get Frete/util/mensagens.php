<?php
function exibir_msg() {
  $mensagem = "";
  if(!empty($_SESSION["msg"])){
    $mensagem = $_SESSION["msg"];
    if(!empty($_SESSION["tipo_msg"])){
      $tipo_msg = $_SESSION["tipo_msg"];
    }
  }
  if (!empty($mensagem)) :
  ?>
  <div id="caixa_erro">
    <p class="alert <?=$tipo_msg?> text-center">
      <?=$mensagem?>
    </p>
  </div>  
  <?php
  endif;
  $_SESSION["msg"] = "";
}
?>