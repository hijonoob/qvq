<?php include 'templates/header.php' ?>
      <?php
        include 'restrito/conexao.php';
        
        if( isset( $_POST['logar'] ) ) {
          $usuario = trim(strip_tags($_POST['usuario'])); 
          $senha = trim(strip_tags($_POST['senha']));
              if ($usuario=='' || $senha=='') {
                echo "<div class='alert alert-warning'> Usuário e senha devem ser preenchidos. </div>";
              } else {
                if ($sql = $conexao->prepare("SELECT senha, perfil, idEscolas, nome FROM escolas WHERE usuario = ?")) {
                  $sql->bind_param('s', $usuario);
                  $sql->execute();
                  $sql->bind_result($senhacomparacao, $permissao, $idEscolas, $nome);
                  $sql->fetch();
                  if ($senhacomparacao == ''){
                    echo "<div class='alert alert-danger'> Erro ao conectar, favor tentar novamente </div>"; // Usuário não encontrado
                  } else {
                      //$senhacomp = crypt($senha, $senhacomparao);
                      if($senhacomparacao == $senha) {
                        // logado, cria as sessões
                        echo $permissao;
                        $_SESSION['usuario']=$usuario;
                        $_SESSION['permissao']=$permissao;
                        $_SESSION['idEscolas']=$idEscolas;
                        $_SESSION['nome']=$nome;
                        echo '<script> location.reload(); </script>';
                      } else {
                          echo "<div class='alert alert-danger'>Erro ao conectar, favor tentar novamente </div>"; // senha incorreta
                      }
                  }
                  $sql->close();
}
                }
              }
      if(isset($_SESSION['permissao'])) {
        echo "<div class='alert alert-success'>Você está logado </div>";
      }
      ?>
      <div id="login">
          <form action="login.php" method="post">  
            <div class="form-input login-form" >
                <label for="usuario">Usuário</label>
                <input name="usuario" type="text" class="form-control" id="usuario" placeholder="Digite seu nome de usuário" autofocus></input>
            </div>
            <div class="form-input login-form">
                <label for="senha">Senha</label>
                <input name="senha" type="password" class="form-control" id="senha" placeholder="Senha"></input><br>
            </div>
            <button type="submit" name="logar" class="btn btn-default">Entrar</button> 
          </form>
      </div>
  </div>
<?php include 'templates/footer.php' ?>
