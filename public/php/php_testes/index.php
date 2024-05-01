<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Dinâmica</title>
</head>
<body>
<?php
session_start(); // Inicia a sessão

// Verifica se a variável de sessão está definida
if (isset($_SESSION['usuario'])) {
    // A sessão está definida, então você pode acessar os dados da sessão
    echo "Bem-vindo, " . $_SESSION['usuario']['nome']; // Supondo que 'nome' seja uma chave no array de dados do usuário
} 
?>
</body>
</html>
