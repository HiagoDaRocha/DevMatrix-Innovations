<?php 

$db_name = getenv('MYSQL_DATABASE');
$db_host = getenv('MYSQL_HOST');
$db_user = getenv('MYSQL_USER');
$db_pass = getenv('MYSQL_PASSWORD');

try {
    $pdo = new PDO("mysql:dbname=$db_name;host=$db_host;port=3306;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    //echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

?>
