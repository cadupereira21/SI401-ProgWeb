<?php

    require "DatabaseManager.php";

    $user1 = new User('Carlos', 'manko', '51481893807', '2002-01-21', '19996060222', 'carloseduardo2101@gmail.com', 'senha123');

    DatabaseManager::GetInstance()->RegisterUser($user1);