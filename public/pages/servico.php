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
    <title>Enviar chamado</title>
    <link rel="stylesheet" href="../assets/css/servico.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

<script src="../assets/js/servico.js"></script>

<header>
    <div class="topnav" id="myTopnav"><br>
      <h2>DevMatrix Innovations</h2><br>
      <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
      <?php if ($administrador) : ?>
        <a href="usuarios.php"><i class="fa fa-group"></i> Usuários</a>
        <a class="active" href="servico.php"><i class="fa fa-briefcase"></i> Serviços</a>
      <?php endif; ?>
      <a href="trabalho.php"><i class="fa fa-archive"></i> Chamados</a>
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

  <br><br><br><br>

<div id="service-box">
    <?php if ($administrador) : ?>
        <form action='' method='post'> <!-- Ajuste o action para o mesmo arquivo PHP -->
            <label for='titulo'>Título do chamado:</label><br>
            <input type='text' name='titulo' id='titulo'><br><br>
            <label for='texto'>Descrição do chamado:</label><br>
            <textarea name='texto' id='texto' rows='4' cols='50' placeholder="Coloque aqui o que é para ser feito no chamado,prazo de entrega e que tipo de pessoa que é necessária para fazer esse chamado, por exemplo: front-end"></textarea><br><br>
            <input type='submit' id="send" name='submit' value='Enviar'>
        </form>
    <?php endif; ?>
    </div>

</body>

</html>
