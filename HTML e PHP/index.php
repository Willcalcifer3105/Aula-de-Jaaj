<?php
// Configurações de conexão com o banco de dados
$servername = "localhost"; // Endereço do servidor MySQL
$username = "root"; // Nome de usuário do MySQL
$password = ""; // Senha do MySQL
$dbname = "cep_db"; // Nome do banco de dados

// Criar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if (isset($_POST['save'])) {
    // Receber os dados do formulário via POST
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    // Preparar a consulta SQL para inserção dos dados
    $stmt = $conn->prepare("INSERT INTO enderecos (cep, logradouro, bairro, cidade, estado) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $cep, $logradouro, $bairro, $cidade, $estado);

    // Executar a consulta e verificar se foi bem-sucedida
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Dados salvos com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao salvar os dados: " . $stmt->error . "</div>";
    }

    // Fechar a consulta
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Endereço</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Buscar Endereço pelo CEP</h1>
    <form id="cepForm" method="POST" action="">
        <div class="form-group">
            <label for="cep">CEP:</label>
            <input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP" maxlength="9" required>
        </div>

        <div class="form-group">
            <label for="logradouro">Logradouro:</label>
            <input type="text" class="form-control" id="logradouro" name="logradouro">
        </div>

        <div class="form-group">
            <label for="bairro">Bairro:</label>
            <input type="text" class="form-control" id="bairro" name="bairro">
        </div>

        <div class="form-group">
            <label for="cidade">Cidade:</label>
            <input type="text" class="form-control" id="cidade" name="cidade">
        </div>

        <div class="form-group">
            <label for="estado">Estado:</label>
            <select class="form-control" id="estado" name="estado">
                <option value="">Selecione o estado</option>
                <option value="AC">Acre</option>
                <option value="AL">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ">Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>
        </div>

        <button type="button" id="buscarCep" class="btn btn-info">Buscar</button>
        <button type="submit" name="save" class="btn btn-primary">Salvar</button>
        <button type="reset" class="btn btn-secondary">Limpar</button>
    </form>
</div>

<script>
document.getElementById('buscarCep').addEventListener('click', function() {
    const cep = document.getElementById('cep').value.replace(/\D/g, '');

    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.logradouro) {
                    document.getElementById('logradouro').value = data.logradouro;
                }
                if (data.bairro) {
                    document.getElementById('bairro').value = data.bairro;
                }
                if (data.localidade) {
                    document.getElementById('cidade').value = data.localidade;
                }
                if (data.uf) {
                    document.getElementById('estado').value = data.uf;
                }
            })
            .catch(error => {
                alert('Erro ao buscar o CEP!');
                console.error('Erro:', error);
            });
    } else {
        alert('CEP inválido! Por favor, digite um CEP com 8 dígitos.');
    }
});
</script>
</body>
</html>
