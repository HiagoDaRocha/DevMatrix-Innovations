<?php
session_start(); // Inicia a sessão

// Conexão com o banco de dados
require 'config.php'; // Certifique-se de incluir o arquivo de configuração com a conexão com o banco de dados

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o login ou email e a senha do formulário
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Consulta o banco de dados para verificar o login ou email do usuário
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE login = :usuario OR email = :usuario");
    $sql->bindValue(':usuario', $usuario);
    $sql->execute();

    // Verifica se o usuário foi encontrado
    if ($sql->rowCount() === 1) {
        // Recupera os dados do usuário
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        // Verifica se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            // Senha correta - Inicia a sessão do usuário
            $_SESSION['usuario'] = $usuario;

            // Redireciona para a página inicial após o login bem-sucedido
            header("Location: php_testes/index.php");
            exit;
        } else {
            // Senha incorreta - Exibe uma alert de erro e exibe uma alert de erro e redireciona para a página inicial
            echo "<script>alert('Senha incorreta. Por favor, tente novamente.'); window.location.href = '../../public/index.html';</script>";

        }
    } else {
        // Usuário não encontrado - Exibe uma mensagem de erro
        header("Location: php_testes/teste.php?error=user_not_found");


    }
}
?>