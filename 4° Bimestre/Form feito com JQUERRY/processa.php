<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ipi_2";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Coletando os dados do formulário
    $nome = $_POST['nome'];
    $dataNascimento = $_POST['dataNascimento'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];
    $complemento = $_POST['complemento'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];

    // Inserindo no banco de dados
    $sql = "INSERT INTO usuario (nome, dataNascimento, email, telefone, logradouro, numero, bairro, cidade, estado, cep, complemento, assunto, mensagem, senha, cpf, rg)
            VALUES ('$nome', '$dataNascimento', '$email', '$telefone', '$logradouro', '$numero', '$bairro', '$cidade', '$estado', '$cep', '$complemento', '$assunto', '$mensagem', '$senha', '$cpf', '$rg')";

    if ($conn->query($sql) === TRUE) {
        echo '<h1>Registro inserido com sucesso!</h1>';
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
