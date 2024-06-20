<?php
session_start(); // Inicia a sessão

//Verifica se a sessão está vazia
if (empty($_SESSION['usuario'])) {
  header("Location:../index.php");
  exit;
}

// Verificar se a variável de sessão 'user_logged_in' não está definida
if (!isset($_SESSION['user_logged_in'])) {
  // Definir a variável de sessão
  $_SESSION['user_logged_in'] = true;
  // Exibir o alerta de boas-vindas com o nome do usuário
  echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Bem-vindo ao DevMatrix Innovations!',
                text: '" . $_SESSION['usuario']['nome'] . "',
                icon: 'success'
            });
        });
    </script>";
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

  } elseif ($action == 'rejeitar') {
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
  <title>DevMatrix Innovations</title>
  <link rel="stylesheet" href="../assets/css/home.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../assets/js/home.js"></script>

  <header>
    <div class="topnav" id="myTopnav"><br>
      <h2>DevMatrix Innovations</h2><br>
      <a class="active" href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
      <?php if ($administrador) : ?>
        <a href="usuarios.php"><i class="fa fa-group"></i> Usuários</a>
        <a href="servico.php"><i class="fa fa-briefcase"></i> Serviços</a>
      <?php endif; ?>
      <a href="trabalho.php"><i class="fa fa-archive"></i> Chamados</a>
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

  <!-- Aqui é onde a box será exibida -->
  <div id="box-container">
    <?php
    // Verifica se há caixas para exibir
    if ($caixas) {
      foreach ($caixas as $caixa) {
        echo "<div class='box'>";
        echo "<h3 id='titulo_box'> {$caixa['titulo']}</h3>";
        echo "<p>{$caixa['texto']}</p>";
        // Adicionei botões para aceitar ou rejeitar a entrega
        echo "<form action='home.php' method='post'>";
        echo "<input type='hidden' name='box_id' value='{$caixa['id']}'>";
        echo "<div class='buttons'>";
        echo "<button type='submit' name='action' value='aceitar' id='accept'>";
        echo "  <div class='svg-wrapper-1'>";
        echo "    <div class='svg-wrapper'>";
        echo "      <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'>";
        echo "        <path fill='none' d='M0 0h24v24H0z'></path>";
        echo "        <path fill='currentColor' d='M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z'></path>";
        echo "      </svg>";
        echo "    </div>";
        echo "  </div>";
        echo "  <span>Aceitar</span>";
        echo "</button>";

        echo "<button type='submit' name='action' value='rejeitar' id='reject'>";
        echo "  <span class='text'>Rejeitar</span>";
        echo "  <span class='icon'>";
        echo "    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>";
        echo "      <path d='M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z'></path>";
        echo "    </svg>";
        echo "  </span>";
        echo "</button>";
        echo"</div>";
        echo "</form>";
        echo "</div>";
        echo "<br>";
      }
    }
    ?>
  </div>

  <?php
  // Verifique se a caixa foi aceita e exiba uma mensagem se necessário
  if (isset($_SESSION['caixa_aceita']) && $_SESSION['caixa_aceita'] === true) {
    // Exiba o alerta após aceitar a caixa
    echo "<script>Swal.fire({ title: 'Chamado aceito!', text: 'Por favor verificar chamado e faze-lo!', icon: 'success' });</script>";

    // Limpe a variável de sessão após exibir a mensagem
    unset($_SESSION['caixa_aceita']);
  }
  ?>
</body>

</html>