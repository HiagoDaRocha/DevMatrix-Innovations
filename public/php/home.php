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
require 'config.php'; // Inclusão com arquivo de configuração com a conexão com o banco de dados

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

  }
}

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