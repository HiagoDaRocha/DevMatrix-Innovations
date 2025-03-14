<?php

session_start(); // Inicia a sessão

require '../php/config.php';

//Verifica se a sessão está vazia
if (empty($_SESSION['usuario'])) {
    header("Location:../index.php");
    exit;
}

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

$id = filter_input(INPUT_GET, 'id');
$sql = "SELECT * FROM usuarios WHERE id = $id";
$sql = $pdo->query($sql);
$info = $sql->fetch();

// Obtém o ID do usuário da sessão
$userId = $_SESSION['usuario']['id'];

// Verifica se a variável de sessão 'usuario' está definida e possui um nome
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nome'])) {
  $nomeCompleto = $_SESSION['usuario']['nome'];

  // Consulta para recuperar os dados do usuário
  $sql = $pdo->prepare("SELECT email, senha, login, telefone, descricao, imagens FROM usuarios WHERE id = ?");
  $sql->bindValue(1, $userId);
  $sql->execute();

  $userData = $sql->fetch(PDO::FETCH_ASSOC);

  if ($userData) {
      $email = $userData['email'];
      $senha = $userData['senha'];
      $login = $userData['login'];
      $telefone = $userData['telefone'];
      $descricao = $userData['descricao'];
      $imagens = $userData['imagens'];
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar permissão</title>
    <link rel="stylesheet" href="../assets/css/edit.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <script src="../assets/js/edit.js"></script>

    <header>
        <div class="topnav" id="myTopnav"><br>
            <h2>DevMatrix Innovations</h2><br>
            <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <?php if ($administrador) : ?>
                <a href="usuarios.php"><i class="fa fa-group"></i> Usuários</a>
                <a href="servico.php"><i class="fa fa-briefcase"></i> Serviços</a>
            <?php endif; ?>
            <a href="trabalho.php"><i class="fa fa-archive"></i> Chamados</a>
            <a href="login.php" id="login">
                <?php if ($imagens == 'login-de-usuario.png') : ?>
                    <?php
                    $caminhoCompleto = getenv('ROUTE_DEFAULT_IMAGE') . $imagens;
                    ?>
                    <img src="<?php echo htmlspecialchars($caminhoCompleto); ?>" id="imgPhoto2">
                <?php else : ?>
                    <?php
                    $caminhoCompleto = getenv('ROUTE_UPLOAD_IMAGE') . $imagens;
                    ?>
                    <img src="<?php echo htmlspecialchars($caminhoCompleto); ?>" id="imgPhoto2">
                <?php endif; ?> Login</a>
            <?php
            echo "<a id='logout' href='../php/logout.php'>Sair da conta</a>";
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

    <div id="permission-box">
        <form method="GET" action="../php/edit.php">
            <input type="hidden" name="id" value="<?= $info['id']; ?>" />
            <input type="hidden" name="nome" id="name" value="<?= isset($info['nome']) ? $info['nome'] : ''; ?>" /><br><br>
            <h3 id="name"><?= isset($info['nome']) ? htmlspecialchars($info['nome'], ENT_QUOTES, 'UTF-8') : ''; ?></h3>
            <br><br>
            <label for='permission'> Nível de acesso</label><br>
            <input type="number" name="permissoes" id="permission" value="<?= isset($info['permissoes']) ? $info['permissoes'] : ''; ?>" />
            <br>
            <input type="submit" id="send" value="Editar" />
        </form>
    </div>

</body>

</html>