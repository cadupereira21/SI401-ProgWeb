<?php
session_start();
$logado = false;
if(isset($_SESSION["usuarioLogado"]) && $_SESSION["usuarioLogado"] === true)
    $logado = true;
$resultadoCadastro = null;
if (!empty($_POST)){
	if (!isset($_POST["nome"]))
	return;

	if (!isset($_POST["usuario"]))
	return;

	if (!isset($_POST["email"]))
	return;

	if (!isset($_POST["senha"]))
	return;

	if (!isset($_POST["cpf"]))
	return;

	if (!isset($_POST["data-nascimento"]))
	return;

	if (!isset($_POST["telefone"]))
	return;

	require_once("./util/processaRegistro.php");
	$resultadoCadastro = processarRegistro($_POST["nome"], $_POST["usuario"], $_POST["email"], $_POST["senha"], $_POST["cpf"], $_POST["data-nascimento"], $_POST["telefone"]);

}
?>

<!DOCTYPE html>
<html lang="pt">

    <head>
        <title> Campo Minado Game - Cadastro </title>
        <meta charset="UTF-8">
           <link rel="stylesheet" type="text/css" href="./StyleSheet/cssUser.css">
    </head>

    <body id="signup">

        <section class="floating-menu" id="floating-menu-signup">
            <form name="signup" method="post" action="signup.php">
                <h1 class="floating-menu-title"> CADASTRO </h1>

                <hr class="floating-menu-bar"/>
                <?php
                     if ($logado){
                         echo"Você já está logado. <a href='game.php'>Clique para ir ao jogo.</a>";
                         echo"<br /><br /><br />";
                     }else{
                        if ($resultadoCadastro != null){
                         echo($resultadoCadastro);
                         echo"<br /><br /><br />";
                        }else{


                ?>
                 <div class="floating-menu-content">
                    <label for="nome">NOME COMPLETO</label>
                    <input type="text" class="text-input" name="nome" id="nome" autocomplete="off" maxlength="40" required pattern="([a-zA-Z]+)( +[a-zA-Z]+)+" title="Deve ser inserido o nome completo">
                </div>

                <div class="floating-menu-content">
                    <label for="usuario">NOME DE USUÁRIO</label>
                    <input type="text" class="text-input" name="usuario" id="usuario" autocomplete="off" maxlength="16" required pattern="[0-9a-zA-Z]{8,16}" title="O nome de usuário deve ter entre 8 a 16 caracteres">
                </div>

                <div class="floating-menu-content">
                    <label for="email">EMAIL</label>
                    <input type="email" class="text-input" name="email" id="email" autocomplete="off" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="email@example.com" title="O formato do email deve seguir o padrão email@example.com">
                </div>

                <div class="floating-menu-content">
                    <label for="senha">SENHA</label>
                    <input type="password" class="text-input" name="senha" id="senha" autocomplete="off" maxlength="16" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}" title="A senha deve conter ao menos um número, uma letra maiúscula e uma letra minúscula. O tamanho total deve estar entre 8 e 16 caracteres">
                </div>

                <div class="floating-menu-content">
                    <label for="cpf">CPF</label>
                    <input type="text" class="text-input" name="cpf" id="cpf" autocomplete="off" maxlength="14" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="123.456.789-00" title="O CPF inserido deve seguir o padrão 123.456.789-00">
                </div>

                <div class="floating-menu-content">
                    <label for="data-nascimento">DATA DE NASCIMENTO</label>
                    <input type="date" class="text-input" name ="data-nascimento" id="data-nascimento" autocomplete="off" title="A data inserida deve seguir o padrão dd/mm/aaaa">
                </div>

                <div class="floating-menu-content">
                    <label for="telefone">TELEFONE</label>
                    <input type="tel" class="text-input" name="telefone" id="telefone" autocomplete="off" maxlength="15" required pattern="(\([0-9]{2}\))\s([9]{1})?([0-9]{4})-([0-9]{4})" placeholder="(99) 99999-9999" title="O telefone deve seguir o padrão (99) 99999-9999 ou (99) 9999-9999">
                </div>

                <br/>
                <div class="floating-menu-content">
                   <input type="submit" id="enviar" class="submit-input" value="Cadastrar">
                </div>

                <br /><br /><br />

                <a href="./login.php">
                    <p id="loginpage">
                        Já possui login?
                    </p>
                </a>
                <?php
                     }}
                ?>
            </form>
        </section>

    </body>

</html>