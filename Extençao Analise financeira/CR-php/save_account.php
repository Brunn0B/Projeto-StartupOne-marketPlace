<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = json_decode(file_get_contents("php://input"), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON inválido: ' . json_last_error_msg());
        }

        if (isset($data['IDCliente'], $data['NomeCliente'], $data['CPF'], $data['Valor'], $data['DataVencimento'], $data['Status'])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "financeiro_db";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                throw new Exception('Erro de conexão: ' . $conn->connect_error);
            }

            $stmt = $conn->prepare("INSERT INTO contas_receber (cliente_id, nome_cliente, CPF, valor, data_vencimento, status) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                throw new Exception('Erro na preparação da consulta: ' . $conn->error);
            }

            $stmt->bind_param("isssss", $data['IDCliente'], $data['NomeCliente'], $data['CPF'], $data['Valor'], $data['DataVencimento'], $data['Status']);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao inserir dados: ' . $stmt->error);
            }

            echo json_encode(array("success" => true, "message" => "Dados inseridos com sucesso"));
            $stmt->close();
            $conn->close();
            die();
        } else {
            throw new Exception('Dados incompletos. Verifique os campos obrigatórios.');
        }
    } else {
        throw new Exception('Método de requisição não permitido');
    }
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
    die();
}
?>
