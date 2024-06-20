<?php
session_start(); // Inicia a sessão

//Verifica se a sessão está vazia
if (empty($_SESSION['usuario'])) {
  header("Location:../index.php");
  exit;
}

// Conexão com o banco de dados
require '../php/config.php'; // Inclusão com arquivo de configuração com a conexão com o banco de dados

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
  <title>Chamados</title>
  <link rel="stylesheet" href="../assets/css/trabalho.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

<script src="../assets/js/trabalho.js"></script>

<header>
    <div class="topnav" id="myTopnav"><br>
      <h2>DevMatrix Innovations</h2><br>
      <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
      <?php if ($administrador) : ?>
        <a href="usuarios.php"><i class="fa fa-group"></i> Usuários</a>
        <a href="servico.php"><i class="fa fa-briefcase"></i> Serviços</a>
      <?php endif; ?>
      <a class="active" href="trabalho.php"><i class="fa fa-archive"></i> Chamados</a>
      <a href="#"><i class="fa fa-user-circle-o"></i> Login</a>
      <?php
      echo "<a href='../php/logout.php'>Sair da conta</a>";
      ?>
      <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
        <div class="container">
          <div class="bar1"></div>
          <div class="bar2"></div>
          <div class="bar3"></div>
        </div>
      </a>
    </div>
  </header>

  <br><br>

  <div id="box-container">
    <?php
    // Verifica se há caixas aceitas para exibir
    if ($caixas_aceitas) {
      foreach ($caixas_aceitas as $caixa) {
        echo "<div class='box'>";
        echo "<h3> {$caixa['titulo']}</h3>";
        echo "<p> {$caixa['texto']}</p>";
        echo "</div>";
        echo "<br>";
      }
    } else {
      echo "<p>Nenhuma caixa aceita encontrada.</p>";
    }
    ?>
  </div>

</body>

</html>
