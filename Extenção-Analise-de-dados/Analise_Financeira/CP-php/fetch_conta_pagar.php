<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financeiro_db";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "SELECT id, fornecedor_id, valor, data_vencimento, status FROM contas_pagar WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $contaPagar = array(
            "id" => $row["id"],
            "fornecedor_id" => $row["fornecedor_id"],
            "valor" => $row["valor"],
            "data_vencimento" => $row["data_vencimento"],
            "status" => $row["status"]
        );
        echo json_encode($contaPagar);
    } else {
        echo json_encode(array("error" => "Conta a pagar não encontrada"));
    }

    $conn->close();
} else {
    echo json_encode(array("error" => "ID da conta a pagar não fornecido"));
}
?>
