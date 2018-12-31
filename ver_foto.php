<?php
require_once 'db_connect.php';
session_start();
//pega os dados no sql
$id = $_SESSION['id_usuario'];
$sql = "SELECT * FROM usuarios WHERE id = '$id'";
$resultado = mysqli_query($connect, $sql);
$dados = mysqli_fetch_array($resultado);
?>
<!DOCTYPE html>
<html lang="pt" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title><?php $dados['nome'] ?></title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<img src="fotos_sql/<?php echo $dados['foto'] ?>">
		<a class="link" href="alterar.php">voltar</a>
	</body>
</html>