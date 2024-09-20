<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['ids']) && is_array($data['ids']) && !empty($data['ids'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "financeiro_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo json_encode(array("error" => "Erro de conexão: " . $conn->connect_error));
            exit();
        }

        $placeholders = implode(',', array_fill(0, count($data['ids']), '?'));
        $sql = "DELETE FROM contas_receber WHERE id IN ({$placeholders})";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo json_encode(array("error" => "Erro ao preparar a declaração: " . $conn->error));
            exit();
        }

        $types = str_repeat('i', count($data['ids']));
        $stmt->bind_param($types, ...$data['ids']);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Contas excluídas com sucesso"));
        } else {
            echo json_encode(array("error" => "Erro ao excluir contas: " . $stmt->error));
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(array("error" => "IDs não fornecidos ou inválidos"));
    }
} else {
    echo json_encode(array("error" => "Método de requisição não permitido"));
}
?>
