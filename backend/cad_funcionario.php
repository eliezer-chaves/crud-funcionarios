<?php
	include 'db/connect.php';
	if (empty($_POST["nome"])||empty($_POST["cpf"])||empty($_POST["sexo"])||empty($_POST["datanasc"])) {
		echo '{ "resultado": "Preencha todos os campos", "status": "incomplete" }';
		return;
	}

	$table = "funcionario_4";

	/* if (!(isset($_POST["nome"])) || !(isset($_POST["cpf"])) || !(isset($_POST["sexo"])) || !(isset($_POST["datanasc"]))) {
		echo '{ "resultado": "Valores invalidos", "status": "incomplete" }';
		return;
	} */
	
	$nome = $_POST["nome"];
	$cpf = $_POST["cpf"];
	$sexo = $_POST["sexo"];
	$datanasc = $_POST["datanasc"];
	
	$conexao = criarConexao();
	// Statement
	//$sql = "insert into funcionario " .
	//	   "(nome, cpf, sexo, data_nascimento)" .
	//	   " values " .
	//	   "('$nome', '$cpf', '$sexo', '$datanasc');";
	//executarQuery($conexao, $sql);
	
	// Prepared Statement Positional fields
	//$sql = "insert into funcionario " .
	//	   "(nome, cpf, sexo, data_nascimento)" .
	//	   " values " .
	//	   "(?, ?, ?, ?);";
	//	   
	//$stmt = $conexao->prepare($sql);
	//$stmt->bindParam(1, $nome);
	//$stmt->bindParam(2, $cpf);
	//$stmt->bindParam(3, $sexo);
	//$stmt->bindParam(4, $datanasc);
	//$stmt->execute();
	
	// Prepared Statement Named fields
	$sql = "insert into ".$table." " .
		   "(nome, cpf, sexo, data_nascimento)" .
		   " values " .
		   "(:nome, :cpf, :sexo, :datanasc);";
		   
	$stmt = $conexao->prepare($sql);
	$stmt->bindParam(':nome', $nome);
	$stmt->bindParam(':cpf', $cpf);
	$stmt->bindParam(':sexo', $sexo);
	$stmt->bindParam(':datanasc', $datanasc);
	$stmt->execute();

	//echo $sql;
	//echo '{ "resultado": "' . round($resultado, 2) . '", "status": "cadastrado", "avaliacao": "' . $avaliacao . '" }'; 
	echo '{ "resultado": "Funcionário cadastrado", "status": "cadastrado" }';
