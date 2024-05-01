<?php 

//conexão com o banco de dados 
require 'config.php';  

session_start(); 

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitiza e valida os dados de entrada
    $nome = filter_input(INPUT_POST, 'name-complete', FILTER_SANITIZE_SPECIAL_CHARS);
    //(FILTER_SANITIZE_SPECIAL_CHARS)Esse filtro serve para transformar tudo escrito em string, caso alguem tente colocar um código no input
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    //(FILTER_VALIDATE_EMAIL)Esse filtro serve para que o dado email seja enviado so se colocar um @
    $senha = password_hash($_POST['password-register'], PASSWORD_DEFAULT);
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
    $telefone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_NUMBER_INT);
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_NUMBER_INT);
    $cargo = filter_input(INPUT_POST, 'linguagem', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $birthday = $_POST['birthday']; // Não é necessário filtrar, pois é do tipo 'date'
    // Arquivo
    $file = $_FILES['file']; // Dados do arquivo
    $file_name = $file['name']; // Nome do arquivo

    // Verifica se todos os campos foram preenchidos e se o e-mail é válido
    if ($nome && $email && $senha && $login && $telefone && $cpf && $cargo && $descricao && $birthday && $file_name) {

        // Verifica se o e-mail já está em uso
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() === 0) {
            // Insere os dados no banco de dados
            $sql = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, login, telefone, cpf, cargo, descricao, birthday, curriculo) VALUES (:nome, :email, :senha, :login, :telefone, :cpf, :cargo, :descricao, :birthday, :curriculo)");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':senha', $senha);
            $sql->bindValue(':login', $login);
            $sql->bindValue(':telefone', $telefone);
            $sql->bindValue(':cpf', $cpf);
            $sql->bindValue(':cargo', $cargo);
            $sql->bindValue(':descricao', $descricao);
            $sql->bindValue(':birthday', $birthday);
            $sql->bindValue(':curriculo', $file_name); // Armazena apenas o nome do arquivo no banco de dados
            $sql->execute();

            // Define a variável de sessão com os dados do novo usuário
$_SESSION['usuario'] = [
    'nome' => $nome,

];

              // Move o arquivo para o diretório desejado
              move_uploaded_file($file['tmp_name'], 'C:/xampp/htdocs/tcc_tecnico/uploads/' . $file_name);


            // Redireciona para a página inicial após o cadastro bem-sucedido
            header("Location: php_testes/index.php");
            exit;
        } else {
            // Redireciona para a página de adicionar em caso de e-mail já em uso
            header("Location: php_testes/teste.php?error=email_exists");
            exit;
        }
    }
}


?>