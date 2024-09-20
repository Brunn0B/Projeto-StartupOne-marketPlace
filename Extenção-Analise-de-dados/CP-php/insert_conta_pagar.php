<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financeiro_db";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['fornecedorId']) && isset($data['valor']) && isset($data['dataVencimento']) && isset($data['status'])) {
    $fornecedorId = $data['fornecedorId'];
    $valor = $data['valor'];
    $dataVencimento = $data['dataVencimento'];
    $status = $data['status'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "INSERT INTO contas_pagar (fornecedor_id, valor, data_vencimento, status) VALUES ('$fornecedorId', '$valor', '$dataVencimento', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("error" => "Erro ao adicionar conta a pagar: " . $conn->error));
    }

    $conn->close();
} else {
    echo json_encode(array("error" => "Dados incompletos"));
}
?>
