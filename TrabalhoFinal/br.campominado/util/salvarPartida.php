<?php

    require_once("./conexao.php");

	$dados = json_decode(file_get_contents('php://input'), true);

    $IdUsuario = mysqli_real_escape_string($conexao, $dados["IdUsuario"]);
    $dataInicio = mysqli_real_escape_string($conexao, $dados["dataInicio"]);
    $modo = mysqli_real_escape_string($conexao, $dados["modo"]);
    $tabuleiro = mysqli_real_escape_string($conexao,  $dados["tabuleiro"]);
    $numBombas = mysqli_real_escape_string($conexao, $dados["numBombas"]);
    $duracao = mysqli_real_escape_string($conexao, $dados["duracao"]);
    $resultado = mysqli_real_escape_string($conexao, $dados["resultado"] == "vitoria");

    $sql = "INSERT INTO game (game_userId, gameDate, gameMode, grid, numBombs, gameTime, isAWin)
    			  VALUES('$IdUsuario', '$dataInicio', '$modo', '$tabuleiro', '$numBombas', '$duracao', '$resultado')";

	if (mysqli_query($conexao, $sql)) {
	  echo "Partida salva";
	} else {
	  echo "Erro ao salvar partida:" . mysqli_error($conexao);
	}
?>