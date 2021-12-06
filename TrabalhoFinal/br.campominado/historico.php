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
require_once("./util/obterHistorico.php");
?>

<!DOCTYPE html>

<html lang="pt-BR">
	<head>
		<title>Histórico - Campo Minado</title>
		<meta charset="UTF-8">
		
		<link rel="stylesheet" href="./StyleSheet/cssHistorico.css">
		<link rel="stylesheet" href="./StyleSheet/cssMenuUsuario.css">
	</head>
	
	<body>	
		<h1>Campo minado Histórico</h1>
		<header class="cabecalho" >		
			
		       <?php include "./util/menuUsuario.php"?>

			<div class="historicoTexto">
				<img src='./Assets/hist.png' alt='' class='histIcon'> Histórico de partidas
			</div>			
			
			<div id="menuVoltar">
				<a href="./game.php" class="btnPagInicial">Página Inicial</a>
			</div>			
		</header>	
		<section>
			<h2>Parte contendo a tabela de histórico</h2>			
			
			<div id="tabelaHist">
				<table id ="tabela">

					<tr class='linhaInfos'>
						<td><img src='./Assets/datahora.png' alt='' class='icone'> Data e hora</td>
						<td><img src='./Assets/modo.png' alt='' class='icone'> Modo de jogo</td>
						<td><img src='./Assets/tamJogo.png' alt='' class='icone'> Tabuleiro</td>
						<td><img src='./Assets/bomba.png' alt='' class='icone'> N bombas</td>
						<td><img src='./Assets/tempo.png' alt='' class='icone'> Tempo</td>
						<td><img src='./Assets/resultado.png' alt='' class='icone'> Resultado</td>
					</tr>
					<?php echo(getHistorico()); ?>


				</table>

			</div>	

				
		</section>
	</body>	
</html>