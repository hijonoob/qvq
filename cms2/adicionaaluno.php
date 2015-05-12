<?php
  include 'templates/checagestor.php';
  include 'templates/header.php';
?>
      <h3> Adicionar Aluno </h3>
      
      <?php
        include 'restrito/conexao.php';
        if( isset( $_POST['criar'] ) ):
          $usuario = $_POST['usuario'];
          $nome = $_POST['nome'];
          $dtNasc = $_POST['dtNasc'];
          $email = $_POST['email'];
          $telFixo = $_POST['telFixo'];
          $telCel = $_POST['telCel'];
          $end = $_POST['end'];
          $cid = $_POST['cid'];
          $est = $_POST['est'];
          $cep = $_POST['cep'];
          $senha = $_POST['senha'];
          $anos_idAno = $_POST['anos_idAno'];
          
          if ($usuario=='' || $nome=='' || $dtNasc=='' || $email=='' || $telFixo=='' ||  $telCel=='' || $end=='' || $cid=='' || $est=='' || $cep=='' || $senha=='' || $anos_idAno=='') {
            echo "<div class='alert alert-warning'> Todos os campos devem ser preenchidos. </div>";
          } else {
            $hoje = date("Y-m-d");
            $param = $conexao->prepare("INSERT INTO alunos(usuario, nome, dtNasc, email, telFixo, telCel, end, cid, est, cep, senha, grupos_idGrupos, anos_idAno, escolas_idEscolas, pontos, qtVit, qtDer, qtEmp, qtPart, qtPergCriad, dtReg, dtUltAces) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 999999, ?, ?, 0, 0, 0, 0, 0, 0, ?, ?)");
            $param->bind_param('ssisiisssssiiss', $usuario, $nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $anos_idAno, $_SESSION['idEscolas'], $hoje, $hoje);            
            if ($param->execute()) {
              echo "<div class='alert alert-success'> Inclusão efetuada com sucesso. </div>";
              $param->close();
            }
          }
        endif;
      ?>
      
      
      <form action="" method="POST" id="adicionaluno">
        <label for="usuario"> Usuário: </label>
          <input type="text" placeholder="usuário para login" class="form-control" name="usuario" autofocus />
        <label for="nome"> Nome: </label>
          <input type="text" placeholder="nome" class="form-control" name="nome" />
        <label for="dtNasc"> Data de Nascimento: </label>
          <input type="text" placeholder="data de nascimento" class="form-control" name="dtNasc" />
        <label for="email"> E-mail: </label>
          <input type="text" placeholder="e-mail" class="form-control" name="email" />
        <label for="telFixo"> Telefone fixo: </label>
          <input type="text" placeholder="telefone fixo" class="form-control" name="telFixo" />
        <label for="telCel"> Telefone celular: </label>
          <input type="text" placeholder="telefone celular" class="form-control" name="telCel" />
        <label for="end"> Endereço: </label>
          <input type="text" placeholder="endereço completo" class="form-control" name="end" />
        <label for="cid"> Cidade: </label>
          <input type="text" placeholder="cidade" class="form-control" name="cid" />
        <label for="est"> Estado: </label>
          <input type="text" placeholder="estado" class="form-control" name="est" />
        <label for="cep"> CEP: </label>
          <input type="text" placeholder="cep" class="form-control" name="cep" />
        <label for="senha"> Senha: </label>
          <input type="text" placeholder="senha para acesso de login" class="form-control" name="senha" />
        <label for="anos_idAno"> Id do Ano: </label>
          <input type="text" placeholder="Id de ano - apenas número" class="form-control" name="anos_idAno" />

        <input type="submit" name="criar" value="Adicionar aluno" class="btn btn-default" />  
      </form>   
    </div>  

<?php include 'templates/footer.php' ?>

