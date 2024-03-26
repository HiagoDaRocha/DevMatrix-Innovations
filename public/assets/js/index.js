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
  window.location.href = "pages/register.html";
}


