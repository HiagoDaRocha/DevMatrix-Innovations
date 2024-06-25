<?php 

require '../php/home.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DevMatrix Innovations</title>
  <link rel="stylesheet" href="../assets/css/home.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
      <a id="login" href="login.php">
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

        echo "</div>";
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