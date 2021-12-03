<?php


?>

<!DOCTYPE html>

<html lang="pt-BR">
	<head>
		<title>Leaderboard - Campo Minado</title>
		<meta charset="UTF-8">
		
		<link rel="stylesheet" href="./StyleSheet/rankingCSS.css">
		<link rel="stylesheet" href="./StyleSheet/cssMenuUsuario.css">
	</head>
	
	<body>	
		<h1>Campo minado Ranking</h1>
		<header class="cabecalho" >		
			
			<?php require "./MenuUsuario.php"?>
			
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
					
				<select name="modoAtual" id="modoDeJogo">
					<option selected disabled hidden>Modo de jogo</option>
					<option value="Clássico">Clássico</option>
					<option value="Rivotril">Rivotril</option>
				</select>

				<table id ="tabela">
					<tr class='linhaInfos'>
						<td><img src='./Assets/rank.png' alt='' class='icone' > Ranking </td>
						<td><img src='./Assets/avatar.png' alt='' class='icone' > Usuário </td>
						<td><img src='./Assets/tamJogo.png' alt='' class='icone'> Tabuleiro</td>
						<td><img src='./Assets/bomba.png' alt='' class='icone'> N bombas</td>
						<td><img src='./Assets/tempo.png' alt='' class='icone'> Tempo Gasto</td>
						<td><img src='./Assets/datahora.png' alt='' class='icone'> Data </td>
						<td><img src='./Assets/resultado.png' alt='' class='icone'> Resultado</td>
						
					</tr>
					<tr class='linhaValores'>
						<td>#1</td>
						<td>Carlos</td>
						<td>10x10</td>
						<td>10</td>
						<td>0:59</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#2</td>
						<td>Carlos</td>
						<td>10x10</td>
						<td>10</td>
						<td>1:20</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#3</td>
						<td>Gabriel</td>
						<td>10x10</td>
						<td>10</td>
						<td>1:35</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#4</td>
						<td>Heloisa</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:00</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#5</td>
						<td>Heloisa</td>
						<td>10x10</td>
						<td>10</td>
						<td>2:59</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#6</td>
						<td>Carlos</td>
						<td>10x10</td>
						<td>10</td>
						<td>3:19</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#7</td>
						<td>Pedro</td>
						<td>10x10</td>
						<td>10</td>
						<td>3:25</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#8</td>
						<td>Pedro</td>
						<td>10x10</td>
						<td>10</td>
						<td>3:49</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#9</td>
						<td>Pedro</td>
						<td>10x10</td>
						<td>10</td>
						<td>5:09</td>
						<td>01/01/2021</td>
						<td>Vitória</td>
					</tr>
					<tr class='linhaValores'>
						<td>#10</td>
						<td>Guilherme</td>
						<td>10x10</td>
						<td>10</td>
						<td>3:59</td>
						<td>01/01/2021</td>
						<td>Derrota</td>
					</tr>

				</table>

				
			</div>
				
		</section>
	</body>	
</html>