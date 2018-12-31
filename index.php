<?php

// conexao

require_once 'db_connect.php';

// sessao

session_start();

if (isset($_POST['btn-login'])):
	$erros = array();
	$email = mysqli_escape_string($connect, $_POST['email']);
	$senha = mysqli_escape_string($connect, $_POST['senha']);
	if (empty($email) or empty($senha)):
		$erros[] = "<p class='alerta_campos'> o campo login e senha precisa ser preenchido</p>";
	else:
		$sql = "SELECT email FROM usuarios WHERE email = '$email'";
		$resultado = mysqli_query($connect, $sql);
		if (mysqli_num_rows($resultado) > 0):
			$senha = base64_encode($senha);
			$sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
			$resultado = mysqli_query($connect, $sql);
			if (mysqli_num_rows($resultado) == 1):
				$dados = mysqli_fetch_array($resultado);
				mysqli_close($connect);
				$_SESSION['logado'] = true;
				$_SESSION['id_usuario'] = $dados['id'];
				header('Location: alterar.php');
			else:
				$erros[] = "<p class='alerta_campos'>Dados incorretos</p>";
			endif;
		else:
			$erros[] = "<p class='alerta_campos'>O usuario não existe</p>";
		endif;
	endif;
endif;

if (isset($_SESSION['logado'])):
	header('location: alterar.php');
endif;
?>

<!DOCTYPE html>
<html lang="pt" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <style>
      body, html{
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
      }
    </style>
</head>

<body>

    <?php
      if(!empty($erros)):
        foreach($erros as $erro):
          echo $erro;
        endforeach;
      endif;
    ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="text" name="email" value="admin" placeholder="admin">
            <input type="password"name="senha" value="admin"placeholder="admin">
            <button type="submit" name="btn-login">entrar</button>
          </form>

</body>

</html>
