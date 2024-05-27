document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.querySelector("#togglePassword"); // Seleciona o botão de alternar senha
  const password = document.querySelector("#password"); // Seleciona o campo de senha

  togglePassword.addEventListener("click", function () {
    // Adiciona um ouvinte de evento para o clique no botão de alternar senha
    const type =
      password.getAttribute("type") === "password" ? "text" : "password"; // Obtém o tipo atual do campo de senha e alterna entre 'password' e 'text'
    password.setAttribute("type", type); // Define o novo tipo de campo de senha

    this.classList.toggle("bi-eye"); // Alterna a classe 'bi-eye' para alterar o ícone do botão de alternar senha
    this.classList.toggle("bi-eye-slash"); // Alterna a classe 'bi-eye-slash' para alterar o ícone do botão de alternar senha
  });
});


function register() {
  window.location.href = "./pages/register.php";
}

document.getElementById('forgotPasswordLink').addEventListener('click', function() {
Swal.mixin({
  input: 'text',
  confirmButtonText: 'Next &rarr;',
  showCancelButton: true,
  progressSteps: ['1', '2'],
}).queue([
  {
    title: 'Redefinir Senha',
    text: 'Digite seu usuário',
    inputPlaceholder: 'Usuário',
    inputValidator: (value) => {
      if (!value) {
        return 'Você precisa digitar seu usuário!';
      }
    },
  },
  {
    title: 'Redefinir Senha',
    text: 'Digite sua nova senha',
    inputPlaceholder: 'Nova Senha',
    inputValidator: (value) => {
      if (!value) {
        return 'Você precisa digitar uma nova senha!';
      }
    },
  },
]).then((result) => {
  if (result.value) {
    const username = result.value[0];
    const newPassword = result.value[1];
    // Criei um formulário temporário para enviar a nova senha ao backend
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = 'php/password.php';

    var usernameInput = document.createElement('input');
    usernameInput.type = 'hidden';
    usernameInput.name = 'username';
    usernameInput.value = username;
    form.appendChild(usernameInput);

    var passwordInput = document.createElement('input');
    passwordInput.type = 'hidden';
    passwordInput.name = 'newPassword';
    passwordInput.value = newPassword;
    form.appendChild(passwordInput);

    document.body.appendChild(form);
    form.submit();
  }
});
});
