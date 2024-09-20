<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financeiro_db";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nome']) && isset($data['cnpj'])) {
    $nome = $data['nome'];
    $cnpj = $data['cnpj'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "INSERT INTO fornecedores (nome, cnpj) VALUES ('$nome', '$cnpj')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("error" => "Erro ao cadastrar fornecedor: " . $conn->error));
    }

    $conn->close();
} else {
    echo json_encode(array("error" => "Dados incompletos"));
}
?>
