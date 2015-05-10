<?php
if(isset($_SESSION['permissao'])) { // se deslogado, redireciona
  header('Location: login.php');
  if(!$permissao > 1) { // se não gestor, redireciona
    header('Location: login.php');
  }
}
?>