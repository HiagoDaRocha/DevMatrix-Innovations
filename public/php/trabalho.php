<?php

session_start();

//Verifica se a sessão está vazia
if (empty($_SESSION['usuario'])) {
  header("Location:../index.php");
  exit;
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
