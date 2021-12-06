<?php



function processarAlteracao($usuarioId, $nome, $telefone, $email){

    require_once("./util/conexao.php");


    $nome = stripcslashes($nome);
    $nome = mysqli_real_escape_string($conexao, $nome);
    $telefone = mysqli_real_escape_string($conexao, $telefone);
    $email = mysqli_real_escape_string($conexao, $email);

    $checagem = "UPDATE user SET name = '$nome', phone = '$telefone', email = '$email' WHERE userId='$usuarioId'";
    echo($checagem);
    $resultado = mysqli_query($conexao, $checagem);
    if (mysqli_affected_rows($conexao) > 0)
        return "Dados alterados com sucesso. <a href='account.php'>Clique para voltar.</a>";
    else
        return "Ocorreu um erro ao alterar os dados. <a href='account.php'>Clique para voltar.</a>";


}

function processarSenha($usuarioId, $senhaAtual, $novaSenha){

    if ($novaSenha == $senhaAtual)
        return "Ocorreu um erro ao alterar sua senha: as duas senhas são iguais. <a href='changepassword.php'>Clique para voltar.</a>";
    require_once("./util/conexao.php");


    $senhaAtual = stripcslashes($senhaAtual);
    $senhaAtual = mysqli_real_escape_string($conexao, $senhaAtual);
    $novaSenha = stripcslashes($novaSenha);
    $novaSenha = mysqli_real_escape_string($conexao, $novaSenha);


    $checagem = "UPDATE user SET password = '$novaSenha' WHERE userId='$usuarioId' AND password = '$senhaAtual';";

    echo($checagem);
    $resultado = mysqli_query($conexao, $checagem);

    if (mysqli_affected_rows($conexao) > 0)
        return "Senha alterada com sucesso. <a href='changepassword.php'>Clique para voltar.</a>";
    else
        return "Ocorreu um erro ao alterar sua senha: senha atual incorreta. <a href='changepassword.php'>Clique para voltar.</a>";


}
?>