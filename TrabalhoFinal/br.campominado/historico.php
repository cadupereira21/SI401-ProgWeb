<?php

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
			
			<?php require "./MenuUsuario.php"?>
			
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
					<tr class='linhaValores'>
						<td>01/01/2021</td>
						<td>Normal</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:00</td>
						<td>Derrota</td>
					</tr>
					<tr class='linhaValores'>
						<td>01/01/2021</td>
						<td>Normal</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:00</td>
						<td>Derrota</td>
					</tr>
					<tr class='linhaValores'>
						<td>01/01/2021</td>
						<td>Normal</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:00</td>
						<td>Derrota</td>
					</tr>
					<tr class='linhaValores'>
						<td>01/01/2021</td>
						<td>Normal</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:00</td>
						<td>Derrota</td>
					</tr>
					<tr class='linhaValores'>
						<td>01/01/2021</td>
						<td>Normal</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:00</td>
						<td>Derrota</td>
					</tr>
					<tr class='linhaValores'>
						<td>01/01/2021</td>
						<td>Normal</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:00</td>
						<td>Derrota</td>
					</tr>
					<tr class='linhaValores'>
						<td>01/01/2021</td>
						<td>Normal</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:00</td>
						<td>Derrota</td>
					</tr>


				</table>

			</div>	

				
		</section>
	</body>	
</html>