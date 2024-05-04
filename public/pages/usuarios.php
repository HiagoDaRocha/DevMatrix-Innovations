<?php
session_start(); // Inicia a sessão

//Verifica se a sessão está vazia
if (empty($_SESSION)) {
    header("Location:../index.php");
    exit;
}

// A sessão está definida, então você pode acessar os dados da sessão
echo "Bem-vindo, " . $_SESSION['usuario']['nome']; // Supondo que 'nome' seja uma chave no array de dados do usuário

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
    <title>Document</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <?php if ($administrador) : ?>
        <?php
        require '../php/config.php';

        // Consulta para obter os dados dos usuários
        $sql = "SELECT id, nome, email, telefone, permissoes FROM usuarios";
        $resultado = $pdo->query($sql);
        ?>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Nível de acesso</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($resultado->rowCount() > 0) : ?>

                    <?php foreach ($resultado as $linha) : ?>
                        <tr>
                            <td><?php echo $linha["id"]; ?></td>
                            <td><?php echo $linha["nome"]; ?></td>
                            <td><?php echo $linha["email"]; ?></td>
                            <td><?php echo $linha["telefone"]; ?></td>
                            <td><?php echo $linha["permissoes"]; ?></td>
                            <td>
                                <a href='edit.php?id=<?php echo $linha["id"]; ?>'>Editar</a>
                                <a href='../delete.php?id=<?php echo $linha["id"]; ?>' onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>

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

    <?php endif; ?>

    <?php
    echo "<a href='../php/logout.php'>Sair da conta</a>";
    ?>

</body>

</html>