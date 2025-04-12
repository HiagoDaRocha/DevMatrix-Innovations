function toggleMenu() {
    var x = document.getElementById("myTopnav");
    x.classList.toggle("responsive");
}

function deletar(event, url){

    event.preventDefault(); // Previne o comportamento padrão do link

    Swal.fire({
        title: "Você tem certeza que quer excluir o usuário?",
        text: "Você não poderá reverter isso!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Deletar",
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {

            window.location.href = url;

        }
      });
}