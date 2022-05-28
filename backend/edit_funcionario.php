<?php
include 'db/connect.php';
$table = "funcionario_4";
$conexao = criarConexao();

if ($_POST["operation"] == 'edit') {
	$codigo = $_POST["index"];

	$sql = "select * from $table where codigo = $codigo ";
	$resultado = executarQuery($conexao, $sql);
	$funcionario = $resultado->fetch();

	echo json_encode($funcionario);
} else if ($_POST["operation"] == 'update') {
	$conexao = criarConexao();

	$codigo = $_POST["codigo"];
	$nome =  $_POST["nome"];
	$cpf =  $_POST["cpf"];
	$sexo =  $_POST["sexo"];
	$data_nascimento =  $_POST["datanasc"];

	$sql = "update ".$table." SET nome = '".$nome."', cpf = '".$cpf."', sexo = '".$sexo."', data_nascimento = '".$data_nascimento."' WHERE codigo = '".$codigo."';";
	
	$resultado = executarQuery($conexao, $sql);

	echo var_dump($resultado);
}
else if ($_POST["operation"] == 'delete') {
	$conexao = criarConexao();

	$codigo = $_POST["codigo"];

	$sql = "delete from ".$table." where codigo = '".$codigo."';";
	$resultado = executarQuery($conexao, $sql);
}
