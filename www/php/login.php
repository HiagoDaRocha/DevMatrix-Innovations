<?php
//conexão com o banco de dados 
require 'config.php';

session_start();

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

//Verifica se a sessão está vazia
if (empty($_SESSION['usuario'])) {
    header("Location:../index.php");
    exit;
}

// Obtém o ID do usuário da sessão
$userId = $_SESSION['usuario']['id'];

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

// Verifica se o formulário foi submetido e se há uma imagem enviada
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['fileImage'])) {
        // Caminho absoluto da pasta 'uploadsImages'
        $uploadDir = realpath(__DIR__ . '/../uploadsImages/') . '/'; 
        $fileName = basename($_FILES['fileImage']['name']);
        $uploadFile = $uploadDir . $fileName;

        // Caminho relativo salvo no banco de dados para ser usado no navegador
        $savePath = '/uploadsImages/' . $fileName;

    // Move a imagem para o diretório desejado
    if (move_uploaded_file($_FILES['fileImage']['tmp_name'], $uploadFile)) {

        // Atualiza o registro do usuário no banco de dados com o caminho da imagem
        $sql = $pdo->prepare("UPDATE usuarios SET imagens = ? WHERE id = ?");
        $sql->execute([$savePath, $userId]);

    } 
}
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = filter_input(INPUT_POST, 'password-login', FILTER_SANITIZE_SPECIAL_CHARS);
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_NUMBER_INT);
    $descricao = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($senha !== false) {
        // Gerar o hash da senha
        $password = password_hash($senha, PASSWORD_DEFAULT);
        
    } else {
        
        header("Location: ../pages/login.php");
    }


    // Atualiza os outros dados no banco de dados
    $sql = $pdo->prepare("UPDATE usuarios SET login = ?, telefone = ?, senha = ?, email = ?, descricao = ? WHERE id = ?");
    $sql->bindValue(1, $login);
    $sql->bindValue(2, $telefone);
    $sql->bindValue(3, $password);
    $sql->bindValue(4, $email);
    $sql->bindValue(5, $descricao);
    $sql->bindValue(6, $userId);
    $sql->execute();

    // Redireciona para a página inicial após a atualização bem-sucedida
    header("Location: ../pages/login.php");
    exit;
}
