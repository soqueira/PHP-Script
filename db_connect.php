<?php
//conexao com banco
  $serverName = "localhost";
  $userName = "root";
  $password = "";
  $db_name = "test";

  $connect = mysqli_connect($serverName, $userName, $password, $db_name);

  if(mysqli_connect_error()){
    echo "falha ao conectar no banco de dados ".mysqli_connect_error();
  }
?>
