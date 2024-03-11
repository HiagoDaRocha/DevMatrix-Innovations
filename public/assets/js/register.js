window.startAnimation = function () {
  var checkbox = document.querySelector('input[type="checkbox"]');

  // Função para aplicar estilos e iniciar animação
  function applyStylesAndAnimation() {
    // Aqui vai todo o código para aplicar os estilos e iniciar a animação
    // ...

    // Estilos para o corpo do documento
    document.body.style.backgroundColor = "#000000";

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

    // Estilos para o contêiner do formulário de cadaster
    var cadasterBox = document.querySelector(".cadaster-box");
    cadasterBox.style.backgroundColor = "#000000";
    cadasterBox.style.border = "1px solid #00ff00";
    cadasterBox.style.color = "#ffffff";

    // Estilos para os labels
    var labelElements = document.querySelectorAll("label");
    labelElements.forEach(function (label) {
      label.style.color = "#00ff00"; // Cor do texto verde
    });

    // Estilos para os botões de envio
    var cadasterButton = document.querySelector(".cadaster-button");
    cadasterButton.style.backgroundColor = "#000000";
    cadasterButton.style.color = "#00ff00";
    cadasterButton.style.border = "1px solid #cccccc";

    // Estilos para o botão "Cadastrar"
    var registerButton = document.querySelector("#register");
    registerButton.style.backgroundColor = "#000000";
    registerButton.style.color = "#00ff00";
    registerButton.style.border = "1px solid #cccccc";

    // Estilos para os campos de texto e senha
    var inputElements = document.querySelectorAll(
      '.cadaster-box input[type="text"], .cadaster-box input[type="password"]'
    );
    inputElements.forEach(function (input) {
      input.style.color = "#00ff00";
      input.style.backgroundColor = "#000000";
      input.style.borderBottom = "1px solid #00ff00";
    });
  }

  // Função para remover estilos e animação
  function removeStylesAndAnimation() {
    // Aqui você removerá todos os estilos e elementos relacionados à animação
    // ...

    // Resetar estilos para o corpo do documento
    document.body.style.fontFamily = "Verdana, Geneva, Tahoma, sans-serif";
    document.body.style.backgroundColor = "#ffffff"; // Cor de fundo branca

    // Resetar estilos para os labels
    var labelElements = document.querySelectorAll("label");
    labelElements.forEach(function (label) {
      label.style.color = "#000000"; // Cor do texto preto
    });

    // Resetar estilos para os títulos de segundo nível
    var h2Elements = document.querySelectorAll("h2");
    h2Elements.forEach(function (h2) {
      // Restaurar estilos padrão dos h2
      h2.style.fontSize = ""; // Resetar o tamanho do texto para o valor padrão
      h2.style.color = ""; // Resetar a cor do texto para o valor padrão
    });

    // Resetar estilos para os títulos de primeiro nível
    var h1Elements = document.querySelectorAll("h1");
    h1Elements.forEach(function (h1) {
      h1.style.display = "flex";
      h1.style.justifyContent = "center";
      h1.style.color = "#000000"; // Cor do texto preto
    });

    // Resetar estilos para os links
    var linkElements = document.querySelectorAll("a");
    linkElements.forEach(function (link) {
      link.style.display = "flex";
      link.style.justifyContent = "center";
      link.style.margin = "20px";
    });

    // Resetar estilos para os links quando passa o mouse por cima
    var hoverLinkElements = document.querySelectorAll("a:hover");
    hoverLinkElements.forEach(function (link) {
      link.style.color = "#3465a5";
    });

    // Resetar estilos para o contêiner do formulário de cadastro
    var cadasterBox = document.querySelector(".cadaster-box");
    cadasterBox.style.width = "70%";
    cadasterBox.style.maxWidth = "500px";
    cadasterBox.style.padding = "20px";
    cadasterBox.style.border = "1px solid #3b3e41";
    cadasterBox.style.borderRadius = "5px";
    cadasterBox.style.margin = "0 auto";
    cadasterBox.style.backgroundColor = "#ffffff"; // Cor de fundo branca
    cadasterBox.style.color = "#000000"; // Cor do texto preto

    // Resetar estilos para os botões de envio
    var cadasterButton = document.querySelector(".cadaster-button");
    cadasterButton.style.backgroundColor = "#14448d";
    cadasterButton.style.border = "1px solid #cccccc";
    cadasterButton.style.cursor = "pointer";
    cadasterButton.style.height = "3em";
    cadasterButton.style.borderRadius = "4%";
    cadasterButton.style.width = "27%";
    cadasterButton.style.display = "flex";
    cadasterButton.style.justifyContent = "center";
    cadasterButton.style.alignItems = "center";
    cadasterButton.style.margin = "auto";
    cadasterButton.style.transition = "transform 0.2s";
    cadasterButton.style.marginTop = "10%";

    // Resetar estilos para o botão "Cadastrar"
    var registerButton = document.querySelector(".register-button");
    registerButton.style.backgroundColor = "#14448d";
    registerButton.style.border = "1px solid #cccccc";
    registerButton.style.cursor = "pointer";
    registerButton.style.height = "3em";
    registerButton.style.borderRadius = "4%";
    registerButton.style.width = "27%";
    registerButton.style.display = "flex";
    registerButton.style.justifyContent = "center";
    registerButton.style.alignItems = "center";
    registerButton.style.margin = "auto";
    registerButton.style.transition = "transform 0.2s";
    registerButton.style.marginTop = "10%";

    // Resetar estilos para os campos de texto e senha
    var inputElements = document.querySelectorAll(
      '.cadaster-box input[type="text"], .cadaster-box input[type="password"]'
    );
    inputElements.forEach(function (input) {
      input.style.width = "40%";
      input.style.padding = "10px";
      input.style.borderRadius = "6px";
      input.style.marginBottom = "5%";
    });

    // Estilos para os campos de texto específicos
    var textAreaElements = document.querySelectorAll("textarea");
    textAreaElements.forEach(function (textarea) {
      textarea.style.width = "99%";
      textarea.style.borderRadius = "6px";
    });

    // Estilos para os campos de data
    var dateInputElements = document.querySelectorAll(
      '.cadaster-box input[type="date"]'
    );
    dateInputElements.forEach(function (input) {
      input.style.borderRadius = "6px";
    });

    // Estilos para os campos de arquivo
    var fileInputElements = document.querySelectorAll(
      '.cadaster-box input[type="file"]'
    );
    fileInputElements.forEach(function (input) {
      input.style.width = "59%";
      input.style.height = "2.2vh";
      input.style.borderRadius = "3px";
    });

    // Estilos para os selects
    var selectElements = document.querySelectorAll("select");
    selectElements.forEach(function (select) {
      select.style.borderRadius = "6px";
    });

    // Resetar estilos para os botões de envio quando passa o mouse por cima
    cadasterButton.addEventListener("mouseover", function () {
      cadasterButton.style.transform = "scale(1.3)";
    });

    registerButton.addEventListener("mouseover", function () {
      registerButton.style.transform = "scale(1.3)";
    });

    // Remover estilos quando o mouse não está mais sobre os botões de envio
    cadasterButton.addEventListener("mouseout", function () {
      cadasterButton.style.transform = "scale(1)";
    });

    registerButton.addEventListener("mouseout", function () {
      registerButton.style.transform = "scale(1)";
    });
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

function go() {
  window.location.href = "../home.html";
}
