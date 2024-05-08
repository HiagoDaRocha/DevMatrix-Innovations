<?php
session_start(); // Inicia a sessão

// Verifica se a sessão está vazia
if (empty($_SESSION['usuario'])) {
    header("Location:../index.php");
    exit;
}

// Conexão com o banco de dados
require '../php/config.php'; // Inclusão do arquivo de configuração com a conexão com o banco de dados

// Consulta o banco de dados para verificar o nível de acesso do usuário
$sql = $pdo->prepare("SELECT permissoes FROM usuarios WHERE login = ?");
$sql->bindValue(1, $_SESSION['usuario']['login']); // Supondo que 'login' seja o nome do campo de login na sua tabela de usuários
$sql->execute();
$dados_usuario = $sql->fetch(PDO::FETCH_ASSOC);

// Verifica se o usuário é administrador
if ($dados_usuario && $dados_usuario['permissoes'] === 1) {
    $administrador = true;
  } else {
    $administrador = false;
  }

// Processamento dos dados do formulário para criar a caixa
if ($administrador && isset($_POST['submit'])) {
    $titulo = $_POST['titulo'];
    $texto = $_POST['texto'];

    // Inserção dos dados no banco de dados
    $stmt = $pdo->prepare("INSERT INTO box (user_id, titulo, texto) VALUES (?, ?, ?)");
    $stmt->execute([$_SESSION['usuario']['id'], $titulo, $texto]);

    // Redirecionamento após o processo de inserção
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Box</title>
</head>

<body>

    <?php if ($administrador) : ?>
        <form action='' method='post'> <!-- Ajuste o action para o mesmo arquivo PHP -->
            <label for='titulo'>Título:</label><br>
            <input type='text' name='titulo' id='titulo'><br><br>
            <label for='texto'>Texto:</label><br>
            <textarea name='texto' id='texto' rows='4' cols='50'></textarea><br><br>
            <input type='submit' name='submit' value='Enviar'>
        </form>
    <?php endif; ?>

    <?php
    echo "<a href='../php/logout.php'>Sair da conta</a>";
    ?>

</body>

</html>
