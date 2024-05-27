<?php
session_start(); // Inicia a sessão

// Conexão com o banco de dados
require '../php/config.php'; // Inclusão com arquivo de configuração com a conexão com o banco de dados

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera o nome de usuário e a nova senha do formulário
    $usuario = $_POST['username']; // Corresponde ao nome do campo enviado pelo JavaScript
    $senhaNova = password_hash($_POST['newPassword'], PASSWORD_DEFAULT); // Corresponde ao nome do campo enviado pelo JavaScript
  
    // Prepara e executa a consulta para atualizar a senha do usuário
    $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE login = ?");
    $stmt->execute([$senhaNova, $usuario]);
    
    // Verifica se a consulta foi bem-sucedida
    if ($stmt->rowCount() > 0) {
        $_SESSION['success_message'] = 'Senha atualizada com sucesso.';
    } else {
        $_SESSION['error_message'] = 'Erro ao atualizar a senha. Verifique o nome de usuário.';
    }

    // Redireciona de volta para a página de login
    header("Location: ../index.php");
    exit;
} else {
    // Caso o método não for post, redireciona de volta para a página de login
    header("Location: ../index.php");
    exit;
}
?>
