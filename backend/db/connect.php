<?php 	
	function criarConexao() {
		$host = 'localhost'; // 200.145.23.2
		$db   = 'fatec';
		$user = 'root';
		$pass = '';
		$charset = 'latin1';
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		$dsn = "mysql:host=$host;port=3306;dbname=$db;charset=$charset";
		try {
			return new PDO($dsn, $user, $pass, $options);
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
	}
	
	function executarQuery($conexao, $sql) {
		try {
			return $conexao->query($sql);
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
	}
?>
