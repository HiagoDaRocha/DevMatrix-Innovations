<?php
session_start(); // Inicia a sessão

//Verifica se a sessão esta vazia
if (empty($_SESSION)) {
    header("Location: ../../index.php");
    exit;
}

// A sessão está definida, então você pode acessar os dados da sessão
echo "Bem-vindo, " . $_SESSION['usuario']['nome']; // Supondo que 'nome' seja uma chave no array de dados do usuário

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    echo "<a href='./../logout.php'>Sair da conta</a>";
    ?>
    
    
</body>
</html>
