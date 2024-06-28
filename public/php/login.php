<?php
//conexão com o banco de dados 
require 'config.php';

session_start();

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
    // Dados do arquivo
    $file_name = $_FILES['fileImage']['name'];
    $file_tmp = $_FILES['fileImage']['tmp_name'];
    $savePath = $file_name; // Caminho onde a imagem será salva

    // Move a imagem para o diretório desejado
    if (move_uploaded_file($file_tmp, 'C:/xampp/htdocs/tcc_tecnico/uploadsImages/' . $savePath)) {

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
