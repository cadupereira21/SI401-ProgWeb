<?php



function processarRegistro($nomeCompleto, $nomeUsuario, $email, $senha, $cpf, $dataNasc, $telefone){


    require_once("./util/conexao.php");

    $nomeCompleto = mysqli_real_escape_string($conexao, $nomeCompleto);
    $nomeUsuario = mysqli_real_escape_string($conexao, $nomeUsuario);
    $email = mysqli_real_escape_string($conexao, $email);
    $senha = mysqli_real_escape_string($conexao, $senha);
    $cpf = mysqli_real_escape_string($conexao, $cpf);
    $dataNasc = mysqli_real_escape_string($conexao, $dataNasc);
    $telefone = mysqli_real_escape_string($conexao, $telefone);

    $checagem = "SELECT * FROM user WHERE username='$nomeUsuario' OR cpf='$cpf' LIMIT 1";
    $resultado = mysqli_query($conexao, $checagem);

    if (mysqli_fetch_assoc($resultado))
            return "Nome de usuário ou cpf já registrado. <a href='signup.php'>Clique para voltar.</a>";

    $inserir = "INSERT INTO user (name, cpf, birthday, phone, username, email, password)
    			  VALUES('$nomeCompleto', '$cpf', '$dataNasc', '$telefone', '$nomeUsuario', '$email', '$senha')";

    $queryInserir = mysqli_query($conexao, $inserir);

    $usuarioId = mysqli_insert_id($conexao);


   // $usuario = new User($usuarioId, $nomeCompleto, $nomeUsuario, $cpf, $dataNasc, $telefone, $email, $senha);

    return "Cadastro realizado com sucesso. <a href='login.php'>Clique para realizar login.</a>";


    }
?>