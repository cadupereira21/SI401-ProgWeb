<?php

session_start();

$logado = false;

if(isset($_SESSION["usuarioLogado"]) && $_SESSION["usuarioLogado"] === true)
    $logado = true;

if (!$logado){
    header("Location: login.php");
    die;
}

$nomeUsuario = $_SESSION['usuarioNome'];
?>


<!DOCTYPE html>
<html lang="pt-BR" id="html">
  <head>
    <title>Campo Minado</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./StyleSheet/cssGame.css">
    <link rel="stylesheet" href="./StyleSheet/cssMenuUsuario.css">
    <script src="./JavaScript/JavaScriptGame.js"></script>
  </head>

  <body id="page-body">
    <h1 class="oculto">Campo minado</h1>
    <header id="cabecalho">

     <h2 class="oculto">Menu de manipulação geral da página</h2>
    <?php include "./util/menuUsuario.php"?>

      <form name="dadosJogo" id="dadosJogo">
        <div class="caixa">
          <label for="numBombas"><img id="imgBomba" src="./Assets/bomba.png" alt="Quantidade de bombas"/></label>
          <input type="number" name="numBombas" id="numBombas" placeholder="Qtd." min="1" required>
        </div>

        <div class="caixa">
          <label for="larguraTab"><img id="imgTamTab" src="./Assets/tamJogo.png" alt="tamanho do tabuleiro"/></label>
          <input type="number" name="larguraTab" id="larguraTab" placeholder="Larg." min="2" required>
          <label for="alturaTab"><span>X</span></label>
          <input type="number" name="alturaTab" id="alturaTab" placeholder="Alt." min="2" required>
        </div>

        <label class= "oculto" for="modoDeJogo">Modo: </label>
        <select name="modoAtual" id="modoDeJogo" required>
          <option selected disabled hidden value="">Modo de jogo</option>
          <option value="Clássico">Clássico</option>
          <option value="Rivotril">Rivotril</option>
        </select>

        <input id="iniciarPartida" type="button" value="Iniciar Partida" onclick="iniciarAPartida()">
      </form>

      <div>
        <a id="btnLeaderboard" href="./leaderboard.php">Leaderboard</a>
      </div>
    </header>

    <section>
      <h2 class="oculto">Parte contendo a visualização do jogo</h2>
      <div id="tempoRestante">
        <span>Tempo restante:</span>
        <span class="marcadorTempo"> XX:XX:XX</span>
      </div>
      <div id="tempoPartida">
        <span>Tempo da partida:</span>
        <span class="marcadorTempo"> 00:00:00</span>
      </div>

      <div id="jogo">
        <div id="dadosDaPartida">
          <span id="celulasAbertas">Células abertas: 0</span>
          <span id="bombasArmadas">Bombas armadas: 0</span>
          <span id="pontuacao">Pontuação: 0</span>
          <button id="btnTrocaModoClique" onclick="trocarModoClique()">
            <img id="imagemModoClique" src="./Assets/cursor.png" alt="Botão de Troca de modo"/>
          </button>
        </div>
        <div id="campoMinado">
        </div>
      </div>

      <div id="trapaca">
        <button id="btnTrapaca" onclick="ativarTrapaca()">Trapaça</button>
      </div>
    </section>
  </body>
</html>