<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financeiro_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$reportType = $_POST['reportType'];

$sql = "";

switch ($reportType) {
    case 'analise_custos':
        $sql = "SELECT * FROM analise_custos WHERE data >= '$startDate' AND data <= '$endDate'";
        break;
        case 'contas_pagar':
            $sql = "SELECT cp.id, f.nome AS fornecedor_nome, f.cnpj AS fornecedor_cnpj, cp.valor, cp.data_vencimento, cp.status, cp.extornado, cp.data_extorno 
                    FROM contas_pagar cp 
                    LEFT JOIN fornecedores f ON cp.fornecedor_id = f.id
                    WHERE cp.data_vencimento >= '$startDate' AND cp.data_vencimento <= '$endDate'";
            break;
        
        
    case 'contas_receber':
        $sql = "SELECT * FROM contas_receber WHERE data_vencimento >= '$startDate' AND data_vencimento <= '$endDate'";
        break;
    case 'fluxo_caixa':
        $sql = "SELECT * FROM fluxo_caixa WHERE data >= '$startDate' AND data <= '$endDate'";
        break;
    case 'orcamentos':
        $sql = "SELECT * FROM orcamentos WHERE data >= '$startDate' AND data <= '$endDate'";
        break;
    case 'relatorios_financeiros':
        $sql = "SELECT * FROM relatorios_financeiros WHERE data >= '$startDate' AND data <= '$endDate'";
        break;
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    while ($fieldInfo = $result->fetch_field()) {
        echo "<th>" . $fieldInfo->name . "</th>";
    }
    echo "</tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . $cell . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum resultado encontrado.";
}

$conn->close();
?>
