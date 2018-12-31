  <?php
  require_once 'db_connect.php';

  session_start();
  $id = $_SESSION['id_usuario'];
  $sql = "SELECT * FROM usuarios WHERE id = '$id'";
  $resultado = mysqli_query($connect, $sql);
  $dados = mysqli_fetch_array($resultado);

  // verificação se está logado

  if (!isset($_SESSION['logado'])) {
    header('location: alterar.php');
  }

  if (isset($_POST['enviar_foto'])) {
    if (isset($_FILES['foto'])) {

      $foto = $_FILES['foto'];

      // Verifica se o arquivo é uma imagem

      if (preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])) {

        // Pega as dimensões da imagem

        $dimensoes = getimagesize($foto["tmp_name"]);

        // Se a imagem for selecionada

        if (!empty($dimensoes)) {
          unlink('fotos_sql/' . $dados['foto']);

          // Pega extensão da imagem

          preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

          // Gera um nome único para a imagem

          $nome_imagem = md5(uniqid(time())) . "." . $ext[1];

          // Caminho de onde ficará a imagem

          $caminho_imagem = "fotos_sql/" . $nome_imagem;

          // Faz o upload da imagem para seu respectivo caminho

          move_uploaded_file($foto["tmp_name"], $caminho_imagem);
          $sql = "UPDATE usuarios SET foto = '$nome_imagem' WHERE id = '$id'";

          // Se os dados forem inseridos com sucesso

          if (mysqli_query($connect, $sql)) {
            header('location: alterar.php');
          }
          else {
            echo "Erro ao inserir imagem";
          }
        }
        else {
          echo "<p class='warning'>Erro ao selecionar imagem</p>";
        }
      }
      else {
        echo "<p class='warning'>Ocorreu um erro, tente novamente</p>";
      }
    }
  }

  mysqli_close($connect);
  ?>
<!DOCTYPE html>
<html lang="pt" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $dados['nome']; ?></title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <form class="" action="alterar.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="foto">
      <button type="submit" name="enviar_foto">Fazer alteração</button>
    </form>
    <img src="fotos_sql/<?php echo $dados['foto'] ?>">
    <a class="link" href="ver_foto.php">Clique aki depois que fazer a alteração</a>
  </body>
</html>
