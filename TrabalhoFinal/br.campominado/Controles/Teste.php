<?php

    require "DatabaseManager.php";
    //DatabaseManager::GetInstance();

    //$user1 = new User(0,'Carlos', 'manko', '51481893807', '2002-01-21', '19996060222', 'carloseduardo2101@gmail.com', 'senha123');
	//$game1 = new Game(0, 1, '2021-12-03', 'Clássico', '10x10', 10, '00:01:35', true);
	
	
    //DatabaseManager::GetInstance()->RegisterUser($user1);
    //DatabaseManager::GetInstance()->RegisterGame($game1);
    $aux = DatabaseManager::GetInstance()->Search("gameId", 0);

    echo $aux->getTime();
?>