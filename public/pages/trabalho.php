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

// Consulta o banco de dados para obter os trabalhos aceitos pelo usuário atual
$stmt = $pdo->prepare("SELECT * FROM trabalho WHERE user_id = ?");
$stmt->execute([$_SESSION['usuario']['id']]);
$trabalhos = $stmt->fetchAll();

// Processamento dos dados do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
  $trabalho_id = $_POST['trabalho_id'];
  $action = $_POST['action'];

  if ($action == 'concluir') {
    // Consulta o banco de dados para obter os dados do trabalho a ser concluído
    $stmt = $pdo->prepare("SELECT * FROM trabalho WHERE id = ? AND user_id = ?");
    $stmt->execute([$trabalho_id, $_SESSION['usuario']['id']]);
    $trabalho = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($trabalho) {

      // Deleta o trabalho da tabela 'trabalho'
      $stmt = $pdo->prepare("DELETE FROM trabalho WHERE id = ?");
      $stmt->execute([$trabalho_id]);

      // Insere os dados do trabalho na tabela 'chamados_concluidos'
      $stmt = $pdo->prepare("INSERT INTO chamados_concluidos (id_user, titulo, texto, data_hora_chamado_concluido) VALUES (?, ?, ?, NOW())");
      $stmt->execute([$_SESSION['usuario']['id'], $trabalho['titulo'], $trabalho['texto']]);
    }

    // Redirecione para a página atual
    header("Location: trabalho.php");
    exit(); // Certifique-se de sair após o redirecionamento

  } elseif ($action == 'rejeitar') {
    // Consulta o banco de dados para obter os dados do trabalho a ser rejeitado
    $stmt = $pdo->prepare("SELECT * FROM trabalho WHERE id = ? AND user_id = ?");
    $stmt->execute([$trabalho_id, $_SESSION['usuario']['id']]);
    $trabalho = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($trabalho) {
      // Insere os dados do trabalho na tabela 'box'
      $stmt = $pdo->prepare("INSERT INTO box (user_id, titulo, texto) VALUES (?, ?, ?)");
      $stmt->execute([$_SESSION['usuario']['id'], $trabalho['titulo'], $trabalho['texto']]);

      // Deleta o trabalho da tabela 'trabalho'
      $stmt = $pdo->prepare("DELETE FROM trabalho WHERE id = ?");
      $stmt->execute([$trabalho_id]);
    }
  }
}

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
      <a href="login.php"><i class="fa fa-user-circle-o"></i> Login</a>
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
        echo "<form action='trabalho.php' method='post'>";
        echo "<input type='hidden' name='trabalho_id' value='{$caixa['id']}'>";
        echo "<div class='buttons'>";

        echo "<button type='submit' name='action' value='concluir' id='accept'>";
        echo "  <div class='svg-wrapper-1'>";
        echo "    <div class='svg-wrapper'>";
        echo "      <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'>";
        echo "        <path fill='none' d='M0 0h24v24H0z'></path>";
        echo "        <path fill='currentColor' d='M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z'></path>";
        echo "      </svg>";
        echo "    </div>";
        echo "  </div>";
        echo "  <span>Concluir</span>";
        echo "</button>";

        echo "<button type='submit' name='action' value='rejeitar' id='reject'>";
        echo "  <span class='text'>Rejeitar</span>";
        echo "  <span class='icon'>";
        echo "    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>";
        echo "      <path d='M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z'></path>";
        echo "    </svg>";
        echo "  </span>";
        echo "</button>";
        echo "</div>";
        echo "</form>";
        echo "</div>";
        echo "<br>";
      }
    } 
  
    ?>
  </div>

</body>

</html>