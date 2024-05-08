<?php
session_start(); // Inicia a sessão

//Verifica se a sessão está vazia
if (empty($_SESSION['usuario'])) {
  header("Location:../index.php");
  exit;
}

// Conexão com o banco de dados
require '../php/config.php'; // Inclusão com arquivo de configuração com a conexão com o banco de dados

// Consulta o banco de dados para obter as caixas aceitas pelo usuário atual
$stmt = $pdo->prepare("SELECT * FROM trabalho WHERE user_id = ?");
$stmt->execute([$_SESSION['usuario']['id']]);
$caixas_aceitas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trabalho</title>
  <link rel="stylesheet" href="../assets/css/home.css" />
</head>

<body>
  <header>
    <h2>Caixas Aceitas</h2>
    <?php
    echo "<p>Bem-vindo, {$_SESSION['usuario']['nome']}</p>";
    echo "<a href='../php/logout.php'>Sair da conta</a>";
    ?>
  </header>

  <div id="box-container">
    <?php
    // Verifica se há caixas aceitas para exibir
    if ($caixas_aceitas) {
      foreach ($caixas_aceitas as $caixa) {
        echo "<div class='box'>";
        echo "<h3>Título: {$caixa['titulo']}</h3>";
        echo "<p>Texto: {$caixa['texto']}</p>";
        echo "</div>";
      }
    } else {
      echo "<p>Nenhuma caixa aceita encontrada.</p>";
    }
    ?>
  </div>

</body>

</html>
