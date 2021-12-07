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

?>