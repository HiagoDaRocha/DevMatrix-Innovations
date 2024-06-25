<?php

require '../php/trabalho.php';

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
      <a href="login.php" id="login">
        <?php if ($imagens == 'login-de-usuario.png') : ?>
          <?php
          $caminhoCompleto = '/tcc_tecnico/public/assets/images/' . $imagens;
          ?>
          <img src="<?php echo htmlspecialchars($caminhoCompleto); ?>" id="imgPhoto2">
        <?php else : ?>
          <?php
          $caminhoCompleto = '/tcc_tecnico/uploadsImages/' . $imagens;
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

  <br><br><br><br>

  <div id="service-box">
    <?php if ($administrador) : ?>
      <form action='' method='post'>
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