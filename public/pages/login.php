<?php

require '../php/login.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DevMatrix Innovations</title>
    <link rel="stylesheet" href="../assets/css/login.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="background-color: #12566D;">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../assets/js/login.js"></script>

    <header>
        <div class="topnav" id="myTopnav"><br>
            <h2>DevMatrix Innovations</h2><br>
            <a href="home.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <?php if ($administrador) : ?>
                <a href="usuarios.php"><i class="fa fa-group"></i> Usuários</a>
                <a href="servico.php"><i class="fa fa-briefcase"></i> Serviços</a>
            <?php endif; ?>
            <a href="trabalho.php"><i class="fa fa-archive"></i> Chamados</a>
            <a class="active" href="login.php">
                <?php if ($imagens == 'login-de-usuario.png') : ?>
                    <?php
                    $caminhoCompleto = '/tcc_tecnico/public/assets/images/' . $imagens;
                    ?>
                    <img src="<?php echo htmlspecialchars($caminhoCompleto); ?>" id="imgPhoto2">
                <?php else : ?>
                    <?php
                    $caminhoCompleto = '/tcc_tecnico/uploadsImages/' . $imagens;
                    ?>
                    <img src="<?php echo htmlspecialchars($caminhoCompleto); ?>" id="imgPhoto2">
                <?php endif; ?> Login</a>
            <?php
            echo "<a id='logout' href='../php/logout.php'>Sair da conta</a>";
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

    <br><br>

    <div class="login-box">

        <form action="../php/login.php" method="post" enctype="multipart/form-data">

            <div class="max-width">
                <div class="imageContainer">
                    <?php if ($imagens == 'login-de-usuario.png') : ?>
                        <?php
                        $caminhoCompleto = '/tcc_tecnico/public/assets/images/' . $imagens;
                        ?>
                        <img src="<?php echo htmlspecialchars($caminhoCompleto); ?>" id="imgPhoto">
                    <?php else : ?>
                        <?php
                        $caminhoCompleto = '/tcc_tecnico/uploadsImages/' . $imagens;
                        ?>
                        <img src="<?php echo htmlspecialchars($caminhoCompleto); ?>" id="imgPhoto">
                    <?php endif; ?>

                </div>
            </div>

            <input type="file" name="fileImage" id="fImage" accept="image/*"><br><br>

            <h4><?php echo ($nomeCompleto); ?></h4><br>

            <label for="login">Login:</label>
            <input type="text" name="login" id="login" placeholder="Digite um login" value="<?php echo htmlspecialchars($login); ?>"><br>

            <label for="telephone">Telefone:</label>
            <input type="tel" name="telephone" id="telephone" maxlength="14" placeholder="Digite seu telefone" value="<?php echo htmlspecialchars($telefone); ?>"><br>

            <div class="password-container">
                <label for="password-login">Senha:</label>
                <input type="password" name="password-login" id="password-login" placeholder="Digite uma senha" value="<?php echo htmlspecialchars($login); ?>"><br>
                <i class="bi bi-eye-slash" id="togglePassword"></i>
            </div>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" value="<?php echo htmlspecialchars($email); ?>">

            <p style="text-align: center;">Fale mais sobre você:</p>
            <textarea name="description" id="description" placeholder="Escreva sobre você, linguagens que você já trabalhou e qual você se considera melhor" cols="30" rows="10"><?php echo htmlspecialchars($descricao); ?></textarea>


            <input type="submit" id="send" name="send" value="Salvar">


        </form>

    </div>

    <script>
        let photo = document.getElementById('imgPhoto');
        let file = document.getElementById('fImage');

        photo.addEventListener('click', () => {
            file.click();
        });

        file.addEventListener('change', () => {

            if (file.files.length <= 0) {
                return;
            }

            let reader = new FileReader();

            reader.onload = () => {
                photo.src = reader.result;
            }

            reader.readAsDataURL(file.files[0]);
        });
    </script>

</body>

</html>