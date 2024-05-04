<?php
session_start(); // Inicia a sessão

//Verifica se a sessão está vazia
if (empty($_SESSION)) {
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="../assets/css/home.css" />
  <style>
    .box {
      border: 2px solid #000;
      padding: 10px;
      margin-bottom: 20px;
      background-color: white;
    }
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../assets/js/home.js"></script>

  <header>
    <div class="topnav" id="myTopnav">
      <h2>DevMatrix Innovations</h2>
      <a class="active" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
      <?php if ($administrador) : ?>
        <a href="usuarios.php"><i class="fa fa-group"></i> Usuários</a>
        <a href="servico.php"><i class="fa fa-briefcase"></i> Serviços</a>
      <?php endif; ?>
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

  <div style="padding-left: 16px">
    <h3>Responsive Topnav Example</h3>
    <p>Resize the browser window to see how it works.</p>
  </div>

  <!-- Aqui é onde a box será exibida -->
  <div id="box-container">
    <?php

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
      // Verifica se foi enviado um título e um texto
      if (!empty($_POST['titulo']) && !empty($_POST['texto'])) {
        $titulo = $_POST['titulo'];
        $texto = $_POST['texto'];

        // Exibe a box com o título e o texto
        echo "<div class='box'>";
        echo "<h3>Título: $titulo</h3>";
        echo "<p>Texto: $texto</p>";

        // Adicionei botões para aceitar ou rejeitar a entrega
        echo "<form id='confirmForm' action='home.php' method='post'>";
        echo "<button type='submit' class='btn-submit'>Aceitar</button>";
        echo "<button type='button' onclick='confirmExclusao()' class='btn-submit'>Rejeitar</button>";
        echo "</form>";

        echo "</div>";
      } else {
        echo "Por favor, preencha o título e o texto.";
      }
    }

    ?>

  </div>

</body>

</html>