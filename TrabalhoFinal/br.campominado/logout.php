<?php

session_start();

if(isset($_SESSION["usuarioLogado"]) && $_SESSION["usuarioLogado"] === true)
	session_destroy();
header("Location: login.php");
?>