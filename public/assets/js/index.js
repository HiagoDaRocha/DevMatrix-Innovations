window.startAnimation = function () {
  var checkbox = document.querySelector('input[type="checkbox"]');

  // Função para aplicar estilos e iniciar animação
  function applyStylesAndAnimation() {
    // Aqui vai todo o código para aplicar os estilos e iniciar a animação
    // ...

    // Estilos para o corpo do documento
    document.body.style.backgroundColor = "#000000";
    document.body.style.overflow = "hidden";

    // Estilos para os títulos de segundo nível
    var h2Elements = document.querySelectorAll("h2");
    h2Elements.forEach(function (h2) {
      h2.style.color = "#00ff00";
    });

    // Estilos para os títulos de primeiro nível
    var h1Elements = document.querySelectorAll("h1");
    h1Elements.forEach(function (h1) {
      h1.style.color = "#00ff00";
    });

    // Estilos para os links
    var linkElements = document.querySelectorAll("a");
    linkElements.forEach(function (link) {
      link.style.color = "#00ff00";
    });

    // Estilos para os links quando passa o mouse por cima
    var hoverLinkElements = document.querySelectorAll("a:hover");
    hoverLinkElements.forEach(function (link) {
      link.style.color = "#7fff00";
    });

    // Estilos para o contêiner do formulário de login
    var loginBox = document.querySelector(".login-box");
    loginBox.style.backgroundColor = "#000000";
    loginBox.style.border = "1px solid #00ff00";
    loginBox.style.color = "#ffffff";

    // Estilos para os botões de envio
    var loginButton = document.querySelector(".login-button");
    loginButton.style.backgroundColor = "#000000";
    loginButton.style.color = "#00ff00";
    loginButton.style.border = "1px solid #cccccc";

    // Estilos para o botão "Cadastrar"
    var registerButton = document.querySelector(".register-button");
    registerButton.style.backgroundColor = "#000000";
    registerButton.style.color = "#00ff00";
    registerButton.style.border = "1px solid #cccccc";

    // Estilos para os campos de texto e senha
    var inputElements = document.querySelectorAll(
      '.login-box input[type="text"], .login-box input[type="password"]'
    );
    inputElements.forEach(function (input) {
      input.style.color = "#00ff00";
      input.style.backgroundColor = "#000000";
      input.style.borderBottom = "1px solid #00ff00";
    });

    // Estilos para os elementos <i>
    var iElements = document.querySelectorAll("i");
    iElements.forEach(function (i) {
      i.style.color = "#00ff00";
    });
  }

  // Função para remover estilos e animação
  function removeStylesAndAnimation() {
    // Aqui você removerá todos os estilos e elementos relacionados à animação
    // ...

    // Resetar estilos para o corpo do documento
    document.body.style.backgroundColor = "";
    document.body.style.overflow = "";

    // Resetar estilos para os títulos de segundo nível
    var h2Elements = document.querySelectorAll("h2");
    h2Elements.forEach(function (h2) {
      h2.style.color = "";
    });

    // Resetar estilos para os títulos de primeiro nível
    var h1Elements = document.querySelectorAll("h1");
    h1Elements.forEach(function (h1) {
      h1.style.color = "";
    });

    // Resetar estilos para os links
    var linkElements = document.querySelectorAll("a");
    linkElements.forEach(function (link) {
      link.style.color = "";
    });

    // Resetar estilos para os links quando passa o mouse por cima
    var hoverLinkElements = document.querySelectorAll("a:hover");
    hoverLinkElements.forEach(function (link) {
      link.style.color = "";
    });

    // Resetar estilos para o contêiner do formulário de login
    var loginBox = document.querySelector(".login-box");
    loginBox.style.backgroundColor = "";
    loginBox.style.border = "";
    loginBox.style.color = "";

    // Resetar estilos para os botões de envio
    var loginButton = document.querySelector(".login-button");
    loginButton.style.backgroundColor = "";
    loginButton.style.color = "";
    loginButton.style.border = "";

    // Resetar estilos para o botão "Cadastrar"
    var registerButton = document.querySelector(".register-button");
    registerButton.style.backgroundColor = "";
    registerButton.style.color = "";
    registerButton.style.border = "";

    // Resetar estilos para os campos de texto e senha
    var inputElements = document.querySelectorAll(
      '.login-box input[type="text"], .login-box input[type="password"]'
    );
    inputElements.forEach(function (input) {
      input.style.color = "";
      input.style.backgroundColor = "";
      input.style.borderBottom = "";
    });

    // Resetar estilos para os elementos <i>
    var iElements = document.querySelectorAll("i");
    iElements.forEach(function (i) {
      i.style.color = "";
    });

    // Resetar estilos para o cabeçalho
    var headerElement = document.querySelector("header");
    headerElement.style.position = "";
    headerElement.style.zIndex = "";
  }

  // Adicione um ouvinte de eventos ao checkbox para alternar a animação
  checkbox.addEventListener("change", function () {
    if (checkbox.checked) {
      applyStylesAndAnimation(); // Ativa a animação quando o checkbox é marcado
    } else {
      removeStylesAndAnimation(); // Desativa a animação quando o checkbox é desmarcado
    }
  });

  // Inicia a animação se o checkbox estiver marcado inicialmente
  if (checkbox.checked) {
    applyStylesAndAnimation();
  }
};

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

function go() {
  window.location.href = "pages/register.html";
}
