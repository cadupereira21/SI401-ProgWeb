<?php
$logado = false;
if(isset($_SESSION["usuarioLogado"]) && $_SESSION["usuarioLogado"] === true)
    $logado = true;

if (!$logado)
        die;
$idUsuario = $_SESSION['usuarioId'];
$nomeUsuario = $_SESSION['usuarioNome'];
?>

 <div id="menuUsuario">
        <div id="btnUsuario">
            <img id="avatar" src="./Assets/avatar.png" alt="Avatar pessoal com acesso ao menu do usuário" width="30" height="30"/>
			<span id="idUser" class="oculto"><?php echo($idUsuario) ?></span>
            <span id="username"><?php echo($nomeUsuario) ?></span>
        </div>
    	<div id="OpcoesMenuUsuario">
            <nav>
            <h3 class="oculto">Links para páginas referentes ao usuário</h3>
            <a href="./account.php">Configuração da Conta</a>
            <a href="./historico.php">Histórico</a>
            <a href="./logout.php">Disconnect</a>
            </nav>
        </div>
    </div>