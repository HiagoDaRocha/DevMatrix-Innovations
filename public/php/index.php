<?php
session_start(); // Inicia a sessão

// Conexão com o banco de dados
require '../php/config.php'; // Inclusão com arquivo de configuração com a conexão com o banco de dados

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o login ou email e a senha do formulário
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);


    // Consulta o banco de dados para verificar o login ou email do usuário
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE login = ? OR email = ?");
    $sql->bindValue(1, $usuario);
    $sql->bindValue(2, $usuario);
    $sql->execute();


    if ($sql->rowCount() === 1) {
        // Recupera os dados do usuário
        $dados_usuario = $sql->fetch(PDO::FETCH_ASSOC);

        // Verifica se o login e a senha estão corretos
        if (($dados_usuario['login'] === $usuario || $dados_usuario['email'] === $usuario) && password_verify($senha, $dados_usuario['senha'])) {
            // (Login ou email) e senha corretos - Inicia a sessão do usuário
            $_SESSION['usuario'] = $dados_usuario;

            // Redireciona apenas se o login for bem-sucedido
            header("Location: ../pages/home.php");
            exit;
        } else {
            // Senha incorreta - Define a mensagem de erro na sessão
            $_SESSION['error_message'] = "Usuário e/ou senha estão incorretos!";
            header("Location: ../index.php");
            exit;
        }
    } else {
        // Usuário não encontrado - Define a mensagem de erro na sessão
        $_SESSION['error_message'] = "Usuário e/ou senha estão incorretos!";
        header("Location: ../index.php");
        exit;
    }
} else {

    // Caso o método não for post irá permanecer na mesma página
    header("Location: ../index.php");
    exit;
}
