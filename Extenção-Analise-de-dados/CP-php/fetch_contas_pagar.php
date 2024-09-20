<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financeiro_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT cp.id, f.nome AS fornecedor_nome, f.cnpj AS fornecedor_cnpj, cp.valor, cp.data_vencimento, cp.status, cp.extornado, cp.data_extorno 
        FROM contas_pagar cp 
        INNER JOIN fornecedores f ON cp.fornecedor_id = f.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $contas_pagar = array();

    while ($row = $result->fetch_assoc()) {
        $contas_pagar[] = $row;
    }

    echo json_encode($contas_pagar);
} else {
    echo json_encode(array());
}

$conn->close();
?>
