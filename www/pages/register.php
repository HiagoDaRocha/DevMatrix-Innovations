<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="../assets/css/register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <header>

        <h1>Bem vindo ao DevMatrix Innovations</h1>


    </header>

    <div class="register-box">
        <h2>Formulário de cadastro</h2>
        <form method="post" action="../php/register.php" enctype="multipart/form-data" id="form">
            <label for="name-complete">Nome completo:</label>
            <input type="text" name="name-complete" id="name-complete" placeholder="Digite seu nome completo" required>

            <label for="login">Login:</label>
            <input type="text" name="login" id="login" placeholder="Digite um login" required><br>

            <label for="telephone">Telefone:</label>
            <input type="tel" name="telephone" id="telephone" maxlength="14" placeholder="Digite seu telefone" required><br>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" maxlength="14" placeholder="Digite seu CPF" required><br>

            <div class="password-container">
                <label for="password-register">Senha:</label>
                <input type="password" name="password-register" id="password-register" placeholder="Digite uma senha" required><br>
                <i class="bi bi-eye-slash" id="togglePassword"></i>
            </div>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" required>

            <label for="birthday">Data de nascimento:</label>
            <input type="date" name="birthday" id="birthday" required><br>

            <label for="file">Curriculo ou <br>portifolio:</label>
            <input type="file" name="file" id="file" required><br><br>

            <label for="option">Domínio:</label>
            <select name="linguagem" required="required" id="option">
                <option value="frontend">Front-end</option>
                <option value="backend">Back-end</option>
                <option value="fullstack">Full-stack</option>
                <option value="c">C</option>
                <option value="c#">C#</option>
                <option value="c++">C++</option>
                <option value="python">Python</option>
                <option value="php">PHP</option>
                <option value="java">Java</option>
                <option value="javascript">JavaScript</option>
                <option value="html">HTML</option>
                <option value="css">CSS</option>
                <option value="ruby">Ruby</option>
                <option value="python">Python</option>
                <option value="go">Go</option>
                <option value="node">Node.js</option>
                <option value="react">React.js</option>
                <option value="vue">Vue.js</option>
                <option value="=typescript">TypeScript</option>
                <option value="=angular">Angular</option>
                <option value="th">Técnico de hardware</option>
                <option value="ts">Técnico de software</option>
            </select>

            <p style="text-align: center;">Fale mais sobre você:</p>
            <textarea name="description" id="description" placeholder="Escreva sobre você, linguagens que você já trabalhou e qual você se considera melhor" cols="30" rows="10" required></textarea>

            <input type="submit" id="register">Cadastrar</button>


        </form>


    </div>


    <footer>

    </footer>

    <script src="../assets/js/register.js"></script>

</body>

</html>