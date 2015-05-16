<?php include 'templates/header.php' ?>
      <?php
        include 'restrito/conexao.php';
        
        if( isset( $_POST['logar'] ) ) {
          $usuario = trim(strip_tags($_POST['usuario'])); 
          $senha = trim(strip_tags($_POST['senha']));
              if ($usuario=='' || $senha=='') {
                echo "<div class='alert alert-warning'> " . _( 'User and password must be typed') . " </div>";
              } else {
                if ($sql = $conexao->prepare("SELECT senha, perfil, idEscolas, nome FROM escolas WHERE usuario = ?")) {
                  $sql->bind_param('s', $usuario);
                  $sql->execute();
                  $sql->bind_result($senhacomparacao, $permissao, $idEscolas, $nome);
                  $sql->fetch();
                  if ($senhacomparacao == ''){
                    echo "<div class='alert alert-danger'> " . _( 'Error conecting, please try again') . " </div>"; // Usuário não encontrado
                  } else {
                      //$senhacomp = crypt($senha, $senhacomparao);
                      if($senhacomparacao == $senha) {
                        $_SESSION['usuario']=$usuario;
                        $_SESSION['permissao']=$permissao;
                        $_SESSION['idEscolas']=$idEscolas;
                        $_SESSION['nome']=$nome;
                        //echo '<script> location.reload(); </script>';
                      } else {
                          echo "<div class='alert alert-danger'>" . _( 'Error conecting, please try again') . "</div>"; // senha incorreta
                      }
                  }
                  $sql->close();
}
                }
              }
      if(isset($_SESSION['permissao'])) {
        echo "<div class='alert alert-success'>" . _( 'You are logged, please reload to view menus') . " </div>";
      }
      ?>
      <div id="login">
          <form action="login.php" method="post">  
            <div class="form-input login-form" >
                <label for="usuario"><?php echo _( 'User'); ?></label>
                <input name="usuario" type="text" class="form-control" id="usuario" placeholder="<?php echo _( 'Type your user name'); ?>" autofocus></input>
            </div>
            <div class="form-input login-form">
                <label for="senha"><?php echo _( 'Password'); ?></label>
                <input name="senha" type="password" class="form-control" id="senha" placeholder="<?php echo _( 'password'); ?>"></input><br>
            </div>
            <button type="submit" name="logar" class="btn btn-default"><?php echo _( 'Log in'); ?></button> 
          </form>
      </div>
  </div>
<?php include 'templates/footer.php' ?>
