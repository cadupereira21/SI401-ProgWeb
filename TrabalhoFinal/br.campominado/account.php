<?php

session_start();

$logado = false;

if(isset($_SESSION["usuarioLogado"]) && $_SESSION["usuarioLogado"] === true)
    $logado = true;

if (!$logado){
    header("Location: login.php");
    die;

}

$nomeUsuario = $_SESSION['usuarioNome'];
$idUsuario = $_SESSION['usuarioId'];
$resultadoAlteracao =  null;
if (!empty($_POST)){
if (!isset($_POST["nome"]))
    return;

if (!isset($_POST["telefone"]))
    return;

if (!isset($_POST["email"]))
    return;
require_once("./util/atualizarConta.php");
$resultadoAlteracao = processarAlteracao($idUsuario, $_POST["nome"], $_POST["telefone"], $_POST["email"]);
}

?>

<!DOCTYPE html>
<html lang="pt">

    <head>
        <title> Campo Minado Game - Conta </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./StyleSheet/cssUser.css">
    </head>

    <body id="account">
        
        <section class="floating-menu" id="floating-menu-account">
            <div>
                <div>
                    <h1 class="floating-menu-title"> CONFIGURAÇÕES DE CONTA </h1>
                    <hr class="floating-menu-bar" id="account-settings-bar"/>
                </div>

                <div id="account-settings-leftcontent" class="account-settings">

                    <img src="./Assets/veldoraIcon.jpg" alt="account-photo" class="account-settings-image">

                    <br />
					<form id="account-settings-leftform" action="./changepassword.php">
						<input type="submit" class="submit-input" id="account-settings-change-password" value="Mudar senha">
					</form>

                </div>

                <div id="account-settings-rightcontent" class="account-settings">

                    <?php if ($resultadoAlteracao != null){
                        echo($resultadoAlteracao."<br>");
                    } else{?>

                    <form name="account" id="account-settings-rightform" method = "post" action="./account.php">

                        <div class="floating-menu-content account-settings-text-input">
                            <label for="nome">NOME COMPLETO</label>
						<input type="text" class="text-input" name="nome" id="nome" autocomplete="off" maxlength="40" required pattern="([a-zA-Z]+)( +[a-zA-Z]+)+" title="Deve ser inserido o nome completo">
                        </div>

                        <div class="floating-menu-content account-settings-text-input">
                            <label for="telefone">TELEFONE</label>
							<input type="tel" class="text-input" name="telefone" id="telefone" autocomplete="off" maxlength="15" required pattern="(\([0-9]{2}\))\s([9]{1})?([0-9]{4})-([0-9]{4})" placeholder="(99) 99999-9999" title="O telefone deve seguir o padrão (99) 99999-9999 ou (99) 9999-9999">
                        </div>

                        <div class="floating-menu-content account-settings-text-input">
                            <label for="email">EMAIL</label>
                        <input type="email" class="text-input" name="email" id="email" autocomplete="off" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="email@example.com" title="O formato do email deve seguir o padrão email@example.com">
						</div>

                    </form>
					<div class="account-settings-footsteps-content">
						<input type="submit" form="account-settings-rightform" class="submit-input" id="account-settings-save" value="Salvar">
					</div>
                <?php } ?>

                </div>
                <?php if ($resultadoAlteracao == null){?>
                <div class="account-settings-footstep">
					<a href="./game.php">
						<p id="voltar">
							Voltar
						</p>
					</a>
                </div>
                <?php } ?>
             </div>
        </section>

    </body>

</html>