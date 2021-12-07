<?php

function processarLogin($nomeUsuario, $senha){

    if (empty($nomeUsuario))
    return "Nome de usuário não pode estar vazio. <a href='login.php'>Clique para voltar.</a>";
    if (empty($senha))
    return "Senha não pode estar vazia. <a href='login.php'>Clique para voltar.</a>";

    require_once("./util/conexao.php");

    $nomeUsuario = stripcslashes($nomeUsuario);
    $senha = stripcslashes($senha);
    $nomeUsuario = mysqli_real_escape_string($conexao, $nomeUsuario);
    $senha = mysqli_real_escape_string($conexao, $senha);

    $checagem = "SELECT * FROM user WHERE username='$nomeUsuario' AND password='$senha' LIMIT 1";
    $resultado = mysqli_query($conexao, $checagem);
    $coluna = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
    $valores = mysqli_num_rows($resultado);

    if ($valores == 1) {
        $usuarioId = $coluna["userId"];
        $_SESSION['usuarioLogado'] = true;
        $_SESSION['usuarioNome'] = $nomeUsuario;
        $_SESSION['usuarioId'] = $usuarioId;
        return "Login realizado com sucesso. <a href='game.php'>Clique para ir ao jogo.</a>";
    }  else{
        return "Nome de usuário ou senha incorretos. <a href='login.php'>Clique para voltar.</a>";
    }
}

?>