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

    $sql = "UPDATE contas_pagar SET extornado = 1, data_extorno = NOW() WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("error" => "Erro ao extornar conta a pagar: " . $conn->error));
    }

    // Fecha conexão
    $conn->close();
} else {
    echo json_encode(array("error" => "ID da conta a pagar não fornecido"));
}
?>
