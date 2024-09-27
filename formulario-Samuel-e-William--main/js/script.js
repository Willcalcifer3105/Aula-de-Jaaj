$(document).ready(function(){
    // Máscaras dos campos
    $('#telefone').mask('(00) 00000-0000');
    $('#cpf').mask('000.000.000-00');
    $('#rg').mask('00.000.000-0');
    $('#cep').mask('00000-000');
});

// Função para buscar o endereço usando o CEP
function buscarEndereco() {
    let cep = document.getElementById('cep').value.replace(/\D/g, '');
    if (cep.length === 8) {
        let url = `https://viacep.com.br/ws/${cep}/json/`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    // Preenchendo os campos com os dados recebidos
                    document.getElementById('logradouro').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                    document.getElementById('estado').value = data.uf;
                } else {
                    alert("CEP não encontrado.");
                }
            })
            .catch(error => {
                console.error("Erro ao buscar o CEP:", error);
                alert("Erro ao buscar o CEP. Verifique a conexão.");
            });
    } else {
        alert("Formato de CEP inválido.");
    }
}

