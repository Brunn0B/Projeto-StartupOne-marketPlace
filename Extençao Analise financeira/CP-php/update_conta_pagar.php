<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financeiro_db";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($data['fornecedorId']) && isset($data['valor']) && isset($data['dataVencimento']) && isset($data['status'])) {
    $id = $data['id'];
    $fornecedorId = $data['fornecedorId'];
    $valor = $data['valor'];
    $dataVencimento = $data['dataVencimento'];
    $status = $data['status'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "UPDATE contas_pagar SET fornecedor_id = '$fornecedorId', valor = '$valor', data_vencimento = '$dataVencimento', status = '$status' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("error" => "Erro ao atualizar conta a pagar: " . $conn->error));
    }

    $conn->close();
} else {
    echo json_encode(array("error" => "Dados incompletos"));
}
?>
