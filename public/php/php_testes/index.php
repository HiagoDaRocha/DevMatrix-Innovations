<?php
session_start(); // Inicia a sessão

// Verifica se a variável de sessão está definida
if (isset($_SESSION['usuario'])) {
    // A sessão está definida, então você pode acessar os dados da sessão
    echo "Bem-vindo, " . $_SESSION['usuario']['nome']; // Supondo que 'nome' seja uma chave no array de dados do usuário
} 
?>
