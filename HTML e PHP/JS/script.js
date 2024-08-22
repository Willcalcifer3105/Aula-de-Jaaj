document.getElementById('cepForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const cep = document.getElementById('cep').value.replace(/\D/g, '');
    const logradouro = document.getElementById('logradouro').value;
    const bairro = document.getElementById('bairro').value;
    const cidade = document.getElementById('cidade').value;
    const estado = document.getElementById('estado').value;

    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!document.getElementById('logradouro').value) {
                    document.getElementById('logradouro').value = data.logradouro;
                }
                if (!document.getElementById('bairro').value) {
                    document.getElementById('bairro').value = data.bairro;
                }
                if (!document.getElementById('cidade').value) {
                    document.getElementById('cidade').value = data.localidade;
                }
                if (!document.getElementById('estado').value) {
                    document.getElementById('estado').value = data.uf;
                }

                // Enviar os dados para o PHP via AJAX
                sendData({ cep, logradouro, bairro, cidade, estado });
            })
            .catch(error => {
                alert('Erro ao buscar o CEP!');
                console.error('Erro:', error);
            });
    } else {
        alert('CEP inválido! Por favor, digite um CEP com 8 dígitos.');
    }
});

function sendData(data) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "save_address.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            alert("Dados enviados e salvos com sucesso!");
        } else {
            alert("Erro ao salvar os dados.");
        }
    };

    xhr.send(`cep=${data.cep}&logradouro=${data.logradouro}&bairro=${data.bairro}&cidade=${data.cidade}&estado=${data.estado}`);
}
