<?php

session_start();

$logado = false;
$resultadoLogin = null;

if(isset($_SESSION["usuarioLogado"]) && $_SESSION["usuarioLogado"] === true)
      $logado = true;

if (!empty($_POST)){
    if (!isset($_POST["usuario"]))
        return;

    if (!isset($_POST["senha"]))
        return;

    require_once("./util/processaLogin.php");
    $resultadoLogin = processarLogin($_POST["usuario"], $_POST["senha"]);


}

?>
<!DOCTYPE html>
<html lang="pt">

    <head>
        <title> Campo Minado Game - Login </title>
        <meta charset="UTF-8">
           <link rel="stylesheet" type="text/css" href="./StyleSheet/cssUser.css">
    </head>

    <body id="login">
        
        <section class="floating-menu" id="floating-menu-login">
            <form name="login" method="post" action="login.php">
                <h1 class="floating-menu-title"> LOGIN </h1>

                <hr class="floating-menu-bar"/>

                <?php
                     if ($logado){
                         echo"Você já está logado. <a href='game.php'>Clique para ir ao jogo.</a>";
                         echo"<br /><br /><br />";
                     } else{
                        if($resultadoLogin != null){
                                echo($resultadoLogin);
                                echo"<br /><br /><br />";
                        }  else {
                        ?>
                        <div class="floating-menu-content">
                    <label for="usuario">USUÁRIO</label>
				<input type="text" class="text-input" name="usuario" id="usuario" required="required" autocomplete="off" maxlength="16">
                </div>

                <div class="floating-menu-content">
                    <label for="senha">SENHA</label>
					<input type="password" class="text-input" name="senha"  id="senha" required="required" autocomplete="off" maxlength="16">
                </div>

                <br/>
                <div class="floating-menu-content">
                    <input type="submit" class="submit-input" value="Entrar">
                </div>

                <br /><br /><br />

                <a href="./signup.php">
                    <p id="signuppage">
                        Cadastre-se
                    </p>
                </a>

                        <?php
                        }  }
                ?>

            </form>
        </section>

    </body>

</html>