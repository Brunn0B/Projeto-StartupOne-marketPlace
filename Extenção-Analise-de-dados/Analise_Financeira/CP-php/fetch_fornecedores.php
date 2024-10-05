<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financeiro_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT id, nome FROM fornecedores ORDER BY nome";
$result = $conn->query($sql);

$fornecedores = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fornecedor = array(
            "id" => $row["id"],
            "nome" => $row["nome"]
        );
        array_push($fornecedores, $fornecedor);
    }
}

echo json_encode($fornecedores);

// Fecha conexão
$conn->close();
?>
