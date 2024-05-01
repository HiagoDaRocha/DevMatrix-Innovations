<?php
session_start(); // Inicia a sessão

// Conexão com o banco de dados
require 'config.php'; // Inclusão com arquivo de configuração com a conexão com o banco de dados

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o login ou email e a senha do formulário
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Consulta o banco de dados para verificar o login ou email do usuário
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE login = :usuario OR email = :usuario");
    $sql->bindValue(':usuario', $usuario);
    $sql->execute();

    $login_sucesso = false;

    if ($sql->rowCount() === 1) {
        // Recupera os dados do usuário
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    
        // Verifica se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            // Senha correta - Inicia a sessão do usuário
            $_SESSION['usuario'] = $usuario;
            $login_sucesso = true;
        }

        if ($login_sucesso) {
            // Login bem-sucedido - Redireciona para a página inicial
            header("Location: php_testes/index.php");
            exit;
        } else {
             // Senha incorreta - Exibe uma mensagem de erro
            header("Location: php_testes/teste.php?error=incorrect_password");
            exit;
        }
    }else {
        // Usuário não encontrado - Exibe uma mensagem de erro
        header("Location: php_testes/teste.php?error=user_not_found");
        exit;
    }
    
    
} else{

    // Caso o método não for post irá permanecer na mesma página
    header("Location: ../index.html");
    exit;

}

?>