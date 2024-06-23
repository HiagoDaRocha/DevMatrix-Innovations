<?php
session_start(); // Inicia a sessão

//Verifica se a sessão está vazia
if (empty($_SESSION)) {
    header("Location:../index.php");
    exit;
}

// A sessão está definida, então você pode acessar os dados da sessão
//echo "Bem-vindo, " . $_SESSION['usuario']['nome']; // Supondo que 'nome' seja uma chave no array de dados do usuário

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link rel="stylesheet" href="../assets/css/usuarios.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

<script src="../assets/js/usuarios.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" ></script>

<header>
    <div class="topnav" id="myTopnav"><br>
      <h2>DevMatrix Innovations</h2><br>
      <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
      <?php if ($administrador) : ?>
        <a class="active" href="usuarios.php"><i class="fa fa-group"></i> Usuários</a>
        <a href="servico.php"><i class="fa fa-briefcase"></i> Serviços</a>
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

  <br>

    <?php if ($administrador) : ?>
        <?php
        require '../php/config.php';

        // Consulta para obter os dados dos usuários
        $sql = "SELECT id, nome, email, telefone, permissoes FROM usuarios";
        $resultado = $pdo->query($sql);
        ?>
<div class="table-responsive">
        <table class="table table-dark table-borderless">

            <thead>
                <tr>
                    <th class="border border-white">ID</th>
                    <th class="border border-white">Nome</th>
                    <th class="border border-white">Email</th>
                    <th class="border border-white">Telefone</th>
                    <th class="border border-white">Nível de acesso</th>
                    <th class="border border-white">Remover usuário</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($resultado->rowCount() > 0) : ?>

                    <?php foreach ($resultado as $linha) : ?>
                        <tr class="border border-white">
                            <td class="border border-white"><?php echo $linha["id"]; ?></td>
                            <td class="border border-white"><?php echo $linha["nome"]; ?></td>
                            <td class="border border-white"><?php echo $linha["email"]; ?></td>
                            <td class="border border-white"><?php echo $linha["telefone"]; ?></td>
                            <td class="border border-white"><a href='edit.php?id=<?php echo $linha["id"]; ?>'><?php echo $linha["permissoes"]; ?></a></td>
                            <td class="border border-white">
                                <a href='../php/delete.php?id=<?php echo $linha["id"]; ?>' onclick="deletar(event, this.href)">Excluir</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>
                    <tr>
                        <td colspan='5'>Nenhum usuário encontrado</td>
                    </tr>
                <?php endif; ?>

            </tbody>

        </table>
        </div>

    <?php endif; ?>

</body>

</html>