// Receber o seletor do campo valor
let inputValor = document.getElementById('valor');

// Verificar se existe o seletor no HTML
if (inputValor) {
    // Aguardar o usuário digitar valor no campo
    inputValor.addEventListener('input', function () {

        // Obter o valor atual removendo qualquer caractere que não seja número
        let valueValor = this.value.replace(/[^\d]/g, '');

        // Adicionar os separadores de milhares
        var formattedValor = (valueValor.slice(0, -2).replace(/\B(?=(\d{3})+(?!\d))/g, '.')) + '' + valueValor.slice(-2);

        // Adicionar a vírgula e até dois dígitos se houver centavos
        formattedValor = formattedValor.slice(0, -2) + ',' + formattedValor.slice(-2);

        // Atualizar o valor do campo
        this.value = formattedValor;

    });
}

// Receber o seletor apagar e percorrer e lista de registro
document.querySelectorAll('.btnDelete').forEach(function (button) {

    // Aguardar o clique do usuário no botão apagar
    button.addEventListener('click', function (event) {

        // Bloquear o recarregamento da página
        event.preventDefault();

        // Receber o atributo que possui o id do registro que deve ser excluído
        var deleteId = this.getAttribute('data-delete-id');

        // SweetAlert
        Swal.fire({
            title: 'Tem certeza?',
            text: 'Você não poderá reverter isso!',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#0d6efd',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Sim, excluir!',
        }).then((result) => {

            // Carregar a página responsável em excluír se o usuário confirmar a exclusão
            if (result.isConfirmed) {
                document.getElementById(`formExcluir${deleteId}`).submit();
            }
        });

    });

});

// Quando carregar a página execute o select2
$(function () {
    $('.select2').select2({
        theme: 'bootstrap-5'
    });
});