<?php
session_start(); // Inicia a sessão

// Define o tempo máximo de inatividade (em segundos)
$tempoMaximoInatividade = 1800; // 30 minutos

// Verifica se o timestamp do último acesso está definido
if (isset($_SESSION['ultimo_acesso'])) {
    // Calcula o tempo de inatividade
    $tempoInativo = time() - $_SESSION['ultimo_acesso'];

    // Se o tempo de inatividade exceder o limite, encerra a sessão
    if ($tempoInativo > $tempoMaximoInatividade) {
        session_unset(); // Remove todas as variáveis de sessão
        session_destroy(); // Destroi a sessão
        header("Location: ../index.php"); // Redireciona para a página de login
        exit;
    }
}

// Atualiza o timestamp do último acesso
$_SESSION['ultimo_acesso'] = time();

// Verifica se a sessão está vazia
if (empty($_SESSION['usuario'])) {
  header("Location:../index.php");
  exit;
}

// Conexão com o banco de dados
require 'config.php'; // Inclusão do arquivo de configuração com a conexão com o banco de dados

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
  $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
  $texto = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_SPECIAL_CHARS);

  // Inserção dos dados no banco de dados
  $stmt = $pdo->prepare("INSERT INTO box (user_id, titulo, texto) VALUES (?, ?, ?)");
  $stmt->execute([$_SESSION['usuario']['id'], $titulo, $texto]);

  // Redirecionamento após o processo de inserção
  header("Location: home.php");
  exit();
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