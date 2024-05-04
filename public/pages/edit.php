<?php

//Verifica se a sessão está vazia
if (empty($_SESSION)) {
    header("Location:../index.php");
    exit;
}

require '../php/config.php';
$id = filter_input(INPUT_GET, 'id');
$sql = "SELECT * FROM usuarios WHERE id = $id";
$sql = $pdo->query($sql);
$info = $sql->fetch();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="GET" action="../php/edit.php">
        <input type="hidden" name="id" value="<?= $info['id']; ?>" />
        <label>
            Nome: <br />
            <input type="text" name="nome" value="<?= isset($info['nome']) ? $info['nome'] : ''; ?>" />
        </label><br /><br />
        <label>
            Nível de acesso:<br />
            <input type="number" name="permissoes" value="<?= isset($info['permissoes']) ? $info['permissoes'] : ''; ?>" />
        </label><br /><br />
        <input type="submit" value="Editar" />
    </form>

    <?php

    echo "<a href='../php/logout.php'>Sair da conta</a>";
    ?>

</body>

</html>