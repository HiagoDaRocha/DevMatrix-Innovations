<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/index.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>

<body>

  <script src="assets/js/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>

  <?php
  session_start();

  // Verifica se há uma mensagem de erro na sessão
  if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    // Exibe o alerta do SweetAlert com a mensagem de erro
    echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: '$error_message',
            });
          </script>";
    // Remove a mensagem de erro da sessão para não exibi-la novamente
    unset($_SESSION['error_message']);
  }
  ?>

  <header>
    <h1>Bem vindo ao DevMatrix Innovations</h1>

  </header>



  <main>

    <div class="login-box">
      <h2>Login</h2>
      <form method="post" action="../public/php/index.php">
        <input type="text" name="usuario" placeholder="Usuário" required />
        <div class="password-container">
          <input type="password" name="senha" id="password" placeholder="Senha" required />
          <i class="bi bi-eye-slash" id="togglePassword"></i>
        </div>

        <button type="submit" class="login-button">Entrar</button>
        <button type="button" class="register-button" onclick="register()">Cadastrar</button>


        <a href="">Esqueceu a senha?</a>
      </form>
    </div>
  </main>

  <footer></footer>





</body>

</html>