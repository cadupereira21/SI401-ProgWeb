<?php


?>

<!DOCTYPE html>
<html lang="pt">

    <head>
        <title> Campo Minado Game - Senha </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./StyleSheet/cssUser.css">
    </head>

    <body id="login">
        
        <section class="floating-menu" id="floating-menu-login">
            <form name="changePassword" action="./account.php">
                <h1 class="floating-menu-title"> SENHA </h1>

                <hr class="floating-menu-bar"/>

                <div class="floating-menu-content">
                    <label for="senhaatual">SENHA ATUAL</label>
					<input type="password" class="text-input" id="senhaatual" autocomplete="off" maxlength="16" required title="Insira a sua senha atual para dar continuidade no processo de troca de senha">
                </div>

                <div class="floating-menu-content">
                    <label for="novasenha">NOVA SENHA</label>  
					<input type="password" class="text-input" id="novasenha" autocomplete="off" maxlength="16" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}" title="A nova senha deve conter ao menos um número, uma letra maiúscula e uma letra minúscula. O tamanho total deve estar entre 8 e 16 caracteres">
				</div>

                <br/>
                <div class="floating-menu-content">
                    <input type="submit" class="submit-input" value="Mudar"> 
                </div>
                
                <br /><br /><br />
				
            </form>
        </section>

    </body>

</html>