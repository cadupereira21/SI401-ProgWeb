<?php

function getHistorico(){

    $logado = false;
    if(isset($_SESSION["usuarioLogado"]) && $_SESSION["usuarioLogado"] === true)
        $logado = true;

    if (!$logado)
        die;

    $idUsuario = $_SESSION['usuarioId'];

    require_once("./util/conexao.php");

    $checagem = "SELECT * FROM game WHERE game_userId='$idUsuario' ORDER BY gameDate DESC;";
    $resultado = mysqli_query($conexao, $checagem);
    $textoHTML = "";

    while($coluna = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
        $textoHTML .= " <tr class='linhaValores'>
 	                        <td>" . date("d/m/Y H:i:s", strtotime($coluna["gameDate"])) . "</td>
						    <td>". $coluna["gameMode"]."</td>
						    <td>". $coluna["grid"]."</td>
						    <td>". $coluna["numBombs"]."</td>
						    <td>". $coluna["gameTime"]."</td>
						    <td>". ($coluna["isAWin"] == 1 ? "Vitória" : "Derrota")."</td>
                        </tr>";

    }
    return $textoHTML;
}
?>