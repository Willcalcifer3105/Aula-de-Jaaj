<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cep_db";

// Criar a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Preparar a consulta SQL para buscar os dados
$sql = "SELECT cep, logradouro, bairro, cidade, estado FROM enderecos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Cadastros</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Cadastros de Endereços</h1>
    <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>CEP</th>
                <th>Logradouro</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['cep']; ?></td>
                <td><?php echo $row['logradouro']; ?></td>
                <td><?php echo $row['bairro']; ?></td>
                <td><?php echo $row['cidade']; ?></td>
                <td><?php echo $row['estado']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-warning">Nenhum cadastro encontrado.</div>
    <?php endif; ?>
</div>
</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>

