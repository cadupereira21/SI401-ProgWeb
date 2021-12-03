<?php
	require "DatabaseManager.php";

	$dados = json_decode(file_get_contents('php://input'), true);

	$game = new Game($dados["IdUsuario"], $dados["dataInicio"], $dados["modo"], $dados["tabuleiro"], $dados["numBombas"], $dados["duracao"], ($dados["resultado"] == "vitoria"));

/*$user1 = new User('Carlos', 'manko', '51481893807', '2002-01-21', '19996060222', 'carloseduardo2101@gmail.com', 'senha123');
DatabaseManager::GetInstance()->RegisterUser($user1);*/

	echo DatabaseManager::GetInstance()->RegisterGame($game);
	
?>