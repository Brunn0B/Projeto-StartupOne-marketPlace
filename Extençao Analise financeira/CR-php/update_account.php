<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financeiro_db";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'], $data['NomeCliente'], $data['Valor'], $data['DataVencimento'], $data['Status'])) {
    die(json_encode(array('error' => 'Dados incompletos.')));
}

$id = $data['id'];
$nomeCliente = $data['NomeCliente'];
$CPF = $data['CPF'];
$valor = $data['Valor'];
$dataVencimento = $data['DataVencimento'];
$status = $data['Status'];

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die(json_encode(array('error' => 'Conexão falhou: ' . $conn->connect_error)));
}

// Prepara e executa a consulta SQL para atualizar a conta a receber
$sql = "UPDATE contas_receber SET nome_cliente='$nomeCliente', valor=$valor, data_vencimento='$dataVencimento', status='$status' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array('success' => true, 'message' => 'Conta atualizada com sucesso.'));
} else {
    echo json_encode(array('error' => 'Erro ao atualizar conta: ' . $conn->error));
}

// Fecha a conexão
$conn->close();
?>
