<?php
if(isset($_SESSION['permissao'])) { // se deslogado, redireciona
  header('Location: login.php');
  if(!$permissao > 0) { // se não jogador, redireciona
    header('Location: login.php');
  }
}
?>