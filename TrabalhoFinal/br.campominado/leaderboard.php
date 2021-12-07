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

require_once ("./util/obterRanking.php");
require_once ("./util/conexao.php");
?>

<!DOCTYPE html>

<html lang="pt-BR">
	<head>
		<title>Leaderboard - Campo Minado</title>
		<meta charset="UTF-8">
		
		<link rel="stylesheet" href="./StyleSheet/rankingCSS.css">
		<link rel="stylesheet" href="./StyleSheet/cssMenuUsuario.css">
		<script src="./JavaScript/AtualizarLeaderboard.js"></script>
	</head>
	
	<body>	
		<h1>Campo minado Ranking</h1>
		<header class="cabecalho" >		
			<h2 class="oculto">Menu de manipulação geral da página</h2>
		    <?php include "./util/menuUsuario.php"?>     
			
			<div class="LeaderbordCabecalho">
				<img src='./Assets/rank.png' alt='' class='rankIcon'> Leaderboard
			</div>			
			
			<div id="menuVoltar">
				<a href="./game.php" class="btnPagInicial">Página Inicial</a>
			</div>			
		</header>	
		<section>
			<h2>Parte contendo a tabela do ranking</h2>
			<div id="tabelaRanking">
					
				<select name="modoAtual" id="modoDeJogo" onchange="mudarVisualizacao(this)">
					<option selected disabled hidden>Modo de jogo: Clássico</option>
					<option value="Clássico">Clássico</option>
					<option value="Rivotril">Rivotril</option>
				</select>

				<table id ="tabela">
				<thead>
					<tr class='linhaInfos'>
						<td><img src='./Assets/rank.png' alt='' class='icone' > Ranking </td>
						<td><img src='./Assets/avatar.png' alt='' class='icone' > Usuário </td>
						<td><img src='./Assets/tamJogo.png' alt='' class='icone'> Tabuleiro</td>
						<td><img src='./Assets/bomba.png' alt='' class='icone'> N bombas</td>
						<td><img src='./Assets/tempo.png' alt='' class='icone'> Tempo Gasto</td>
						<td><img src='./Assets/datahora.png' alt='' class='icone'> Data </td>
						<td><img src='./Assets/resultado.png' alt='' class='icone'> Resultado</td>						
					</tr>
				</thead>
					<tbody>
						<?php echo(getRanking('Classico')); ?>
					</tbody>
				</table>				
			</div>				
		</section>
	</body>	
</html>