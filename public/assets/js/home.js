function confirmExclusao() {
    // Exibir o alerta do SweetAlert para confirmar a exclusão
    Swal.fire({
      title: 'Tem certeza?',
      text: 'Você deseja rejeitar esta entrega?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Submeter o formulário de exclusão
        document.getElementById('confirmForm').submit();
      }
    });
}
  
function toggleMenu() {
    var x = document.getElementById("myTopnav");
    x.classList.toggle("responsive");
}
