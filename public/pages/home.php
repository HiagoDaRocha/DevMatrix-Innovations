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

// Consulta o banco de dados para obter as caixas
$stmt = $pdo->query("SELECT * FROM box");
$caixas = $stmt->fetchAll();

// Processamento dos dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
  $box_id = $_POST['box_id'];
  $action = $_POST['action'];

  if ($action == 'aceitar') {
    // Consulta o banco de dados para obter os dados da caixa a ser aceita
    $stmt = $pdo->prepare("SELECT * FROM box WHERE id = ?");
    $stmt->execute([$box_id]);
    $caixa = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se a consulta foi bem-sucedida e se $caixa não está vazio
    if ($caixa && !empty($caixa)) {
      // Após aceitar a caixa, remova-a da tabela 'box'
      $stmt = $pdo->prepare("DELETE FROM box WHERE id = ?");
      $stmt->execute([$box_id]);

      // Insere os dados da caixa aceita na tabela 'trabalho' do usuário correspondente
      $stmt = $pdo->prepare("INSERT INTO trabalho (user_id, titulo, texto) VALUES (?, ?, ?)");
      $stmt->execute([$_SESSION['usuario']['id'], $caixa['titulo'], $caixa['texto']]);
    }

       // Armazene temporariamente o estado da caixa aceita na sessão
  $_SESSION['caixa_aceita'] = true;

  // Redirecione para a página atual
  header("Location: home.php");
  exit(); // Certifique-se de sair após o redirecionamento
 
 }elseif ($action == 'rejeitar') {
    // Verifica se a caixa pertence ao usuário atual antes de excluí-la
    $stmt = $pdo->prepare("SELECT * FROM box WHERE id = ? AND user_id = ?");
    $stmt->execute([$box_id, $_SESSION['usuario']['id']]);
    $caixa = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($caixa) {
      // Exclui a caixa apenas se pertencer ao usuário atual
      $stmt = $pdo->prepare("DELETE FROM box WHERE id = ?");
      $stmt->execute([$box_id]);
    }
  
}
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
 <!-- Aqui é onde a box será exibida -->
<div id="box-container">
  <?php
  // Verifica se há caixas para exibir
  if ($caixas) {
    foreach ($caixas as $caixa) {
      echo "<div class='box'>";
      echo "<h3>Título: {$caixa['titulo']}</h3>";
      echo "<p>Texto: {$caixa['texto']}</p>";
      // Adicionei botões para aceitar ou rejeitar a entrega
      echo "<form action='home.php' method='post'>";
      echo "<input type='hidden' name='box_id' value='{$caixa['id']}'>";
      echo "<button type='submit' name='action' value='aceitar' class='btn-submit'>Aceitar</button>";
      echo "<button type='submit' name='action' value='rejeitar' class='btn-submit'>Rejeitar</button>";
      echo "</form>";
      echo "</div>";
    }
  }
  ?>
</div>

<?php
// Verifique se a caixa foi aceita e exiba uma mensagem se necessário
if (isset($_SESSION['caixa_aceita']) && $_SESSION['caixa_aceita'] === true) {
  // Exiba o alerta após aceitar a caixa
  echo "<script>Swal.fire({ title: 'Good job!', text: 'You clicked the button!', icon: 'success' });</script>";

  // Limpe a variável de sessão após exibir a mensagem
  unset($_SESSION['caixa_aceita']);
}
?>
</body>

</html>
