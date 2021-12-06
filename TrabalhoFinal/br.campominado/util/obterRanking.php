<?php

if(isset($_POST["modo"])){
	echo getRanking($_POST["modo"]);
}

function getRanking($modo){
	if(isset($_POST["modo"])){
		 include("../util/conexao.php");
	}else{
		include("./util/conexao.php");
	}
	$manipulacaoLarguraGrid = "CONVERT(SUBSTRING(grid,1, LOCATE('x', grid)-1), SIGNED INTEGER)";
	$manipulacaoAlturaGrid = "CONVERT(SUBSTRING(grid, LOCATE('x', grid) + 1), SIGNED INTEGER)";
    $checagem = "SELECT username, grid, numBombs, gameTime, gameDate, isAWin FROM game INNER JOIN user on user.userId = game.game_userID WHERE game.gameMode = '$modo' AND isAWin = 1 ORDER BY $manipulacaoAlturaGrid * $manipulacaoLarguraGrid DESC, gameTime ASC LIMIT 10;";

    $resultado = mysqli_query($conexao, $checagem);
    $textoHTML = "";
    $rank = 1;
    while($coluna = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
        $textoHTML .= " <tr class='linhaValores'>
                            <td>" . $rank. "</td>
      						<td>". $coluna["username"]."</td>   
 						    <td>". $coluna["grid"]."</td>
						    <td>". $coluna["numBombs"]."</td>            
				            <td>". $coluna["gameTime"]."</td>       
 	                        <td>" . date("d/m/Y H:i:s", strtotime($coluna["gameDate"])) . "</td>
						    <td>". ($coluna["isAWin"] == 1 ? "Vitória" : "Derrota")."</td>
                        </tr>";
        $rank++;
    }
	
	while($rank<=10){
		$textoHTML .= " <tr class='linhaValores'>
					<td>" . $rank. "</td>
					<td></td>   
					<td></td>
					<td></td>            
					<td></td>       
					<td></td>
					<td></td>
				</tr>";
        $rank++;
	}
	
    return $textoHTML;
}

?>