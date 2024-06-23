function toggleMenu() {
  var x = document.getElementById("myTopnav");
  x.classList.toggle("responsive");
}

document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.querySelector("#togglePassword"); // Seleciona o botão de alternar senha
  const password = document.querySelector("#password-login"); // Seleciona o campo de senha

  togglePassword.addEventListener("click", function () {
    // Adiciona um ouvinte de evento para o clique no botão de alternar senha
    const type =
      password.getAttribute("type") === "password" ? "text" : "password"; // Obtém o tipo atual do campo de senha e alterna entre 'password' e 'text'
    password.setAttribute("type", type); // Define o novo tipo de campo de senha

    this.classList.toggle("bi-eye"); // Alterna a classe 'bi-eye' para alterar o ícone do botão de alternar senha
    this.classList.toggle("bi-eye-slash"); // Alterna a classe 'bi-eye-slash' para alterar o ícone do botão de alternar senha
  });

  const form = document.getElementById("form");
  const telefoneInput = document.getElementById("telephone");

  telefoneInput.addEventListener("keypress", () => {
    telefoneInput.value = telefoneInput.value.replace(/[^\d()\-]/g, "");

    let inputTelephoneLength = telefoneInput.value.length;

    if (inputTelephoneLength === 1) {
      telefoneInput.value = "(" + telefoneInput.value;
    } else if (inputTelephoneLength === 3) {
      telefoneInput.value += ")";
    } else if (inputTelephoneLength === 9) {
      telefoneInput.value += "-";
    }
  });

  form.addEventListener("submit", (e) => {
    // Verifica se o campo de telefone tem exatamente 14 caracteres
    if (telefoneInput.value.length !== 14) {
      e.preventDefault(); // Impede o envio do formulário
      Swal.fire({
        title: "Oops...",
        text: "O número do celular deve conter DDD com dois números e nove números do telefone e não conter letras!",
        icon: "error",
      });
    }
  });
  
});
