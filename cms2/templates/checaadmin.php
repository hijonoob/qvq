<?php
if(isset($_SESSION['permissao'])) { // se deslogado, redireciona
  header('Location: login.php');
  if(!$permissao > 2) { // se não admin, redireciona
    header('Location: login.php');
  }
}
?>