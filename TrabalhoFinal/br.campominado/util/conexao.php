<?php

require_once "DatabaseManager.php";

if (!defined('DB_SERVER'))
define('DB_SERVER', 'localhost');
if (!defined('DB_USERNAME'))
define('DB_USERNAME', DatabaseManager::GetInstance()->GetUsername());
if (!defined('DB_PASSWORD'))
define('DB_PASSWORD', DatabaseManager::GetInstance()->GetPassword());
if (!defined('DB_NAME'))
define('DB_NAME', DatabaseManager::GetInstance()->GetDbName());


$conexao = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$conexao){
	die("Erro de conexão com o banco MySQL!");
}
/*
$a = "DROP TABLE game;";
$b = "CREATE TABLE IF NOT EXISTS `game` (
      `gameId` smallint(6) NOT NULL AUTO_INCREMENT,
      `game_userId` smallint(6) NOT NULL,
      `gameDate` datetime NOT NULL,
      `gameMode` char(8) NOT NULL,
      `grid` char(7) NOT NULL,
      `numBombs` int(11) NOT NULL,
      `gameTime` time NOT NULL,
      `isAWin` bit(1) NOT NULL,
       PRIMARY KEY (`gameId`),
       KEY `game_userId` (`game_userId`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
echo mysqli_query($conexao,$a);
echo mysqli_query($conexao,$b);
echo "ok";
*/

?>