$(document).ready(function(){
    // Máscaras dos campos
    $('#telefone').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#rg').mask('00.000.000-0');
    $('#cep').mask('00000-000');

    // Evento para buscar o endereço quando o CEP mudar
    $('#cep').on('blur', function() {
        buscarEndereco();
    });
});

// Função para buscar o endereço usando o CEP
function buscarEndereco() {
    var cep = $('#cep').val().replace(/\D/g, ''); // Obtém o valor do campo e remove caracteres não numéricos
    if (cep.length === 8) {
        var url = `https://viacep.com.br/ws/${cep}/json/`;

        // Usando o método $.getJSON do jQuery para fazer a requisição AJAX
        $.getJSON(url, function(data) {
            if (!data.erro) {
                // Preenchendo os campos com os dados recebidos
                $('#logradouro').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#cidade').val(data.localidade);
                $('#estado').val(data.uf);
            } else {
                alert("CEP não encontrado.");
            }
        }).fail(function() {
            alert("Erro ao buscar o CEP. Verifique a conexão.");
        });
    } else {
        alert("Formato de CEP inválido.");
    }
}
