<?php
include 'db/connect.php';

$conexao = criarConexao();
$table = "funcionario_4";
$sql = "select * from ".$table.";";
$resultado = executarQuery($conexao, $sql);

$sql = "SELECT COUNT(*) FROM ".$table.";";
$stmt = executarQuery($conexao, $sql);
$totalROWS = $stmt->fetchColumn();

$funcionarios = [];

while ($row = $resultado->fetch()) {

	$funcionario = '{"codigo":"' . $row['codigo'] . '" ,"nome":"' . $row['nome'] . '","cpf":"' . $row['cpf'] . '","sexo":"' . $row['sexo'] . '","data_nascimento":"' . $row['data_nascimento'] . '"}';
	array_push($funcionarios, $funcionario);
}

if ($totalROWS == 0){
	echo ' {"status" : "vazio"}';
} else {
	echo json_encode($funcionarios);
}

