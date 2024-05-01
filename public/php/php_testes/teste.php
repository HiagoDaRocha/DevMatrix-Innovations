<?php


// Verificar se há um erro específico definido na URL
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    if ($error === 'email_exists') {
        echo "<p style='color: red;'>Erro: O e-mail fornecido já está em uso. Por favor, escolha outro e-mail.</p>";
    } elseif ($error === 'user_not_found') {
        echo "<p style='color: red;'>Erro: Usuário não encontrado.</p>";
    }
}

?>