<?php
  include 'templates/checagestor.php';
  include 'templates/header.php';
  $idGrupo = htmlspecialchars($_GET["grupo"]);
?>
<script language="javascript" type="text/javascript">
    /* Author :: Dharmendra Patri | Email :: dharam.new@gmail.com | Site :: http://lovewithbug.com | http://forthera.com */
    function move_list_items(sourceid, destinationid) {
      var alunos = "";
      $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
      $("#from_select_list option").each(function()
      {
          alunos =  alunos + " " + $(this).val();
      });
      $("#listaAlunosNova").val(alunos);
    }
    function move_list_items_all(sourceid, destinationid) {
      var alunos = "";
      $("#"+sourceid+" option").appendTo("#"+destinationid);
      $("#from_select_list option").each(function()
      {
          alunos =  alunos + " " + $(this).val();
      });
      $("#listaAlunosNova").val(alunos);
    }
</script>
<style>
  select#from_select_list { width: 90%;}
  select#to_select_list { width: 90%; }
  table { width: 100%; }
  tr { width: 100%; }
  td { width: 50%; }
</style>

      <h3> Editar Alunos do Grupo <?php echo $idGrupo; ?> </h3>
      <table>

        <?php
          include 'restrito/conexao.php';
          if( isset( $_POST['salvarAlunosGrupoInput'] ) ):
              $listaAlunosNova = trim($_POST['listaAlunosNova']);
              $listaAlunosAntiga = trim($_POST['listaAlunosAntiga']);
              
              if ($listaAlunosNova=='') {
                echo "<div class='alert alert-warning'> Erro ao salvar dados - Não permitido remover todos os alunos. </div>";
              } else if ($listaAlunosAntiga == $listaAlunosNova) 
                echo "<div class='alert alert-warning'> Não houve alteração no grupo. </div>";
              else {
                $listAlunAnt = explode(" ", $listaAlunosAntiga);
                $listAlunNov = explode(" ", $listaAlunosNova);
                // Encontra itens novos
                foreach ($listAlunNov as &$aluno) {
                  if (!in_array($aluno, $listAlunAnt)) { 
                      $param = $conexao->prepare("UPDATE alunos SET grupos_idGrupos = ? WHERE usuario = ?");
                      $param->bind_param('is', $idGrupo, $aluno);
                      if ($param->execute()) {
                        echo "<div class='alert alert-success'> Aluno " .  $aluno . " adicionado ao grupo " . $idGrupo ." </div>";
                        $param->close();
                      }
                  }
                }
                // Encontra itens removidos
                foreach ($listAlunAnt as &$aluno) {
                  if (!in_array($aluno, $listAlunNov)) {
                    $param = $conexao->prepare("UPDATE alunos SET grupos_idGrupos = 999999 WHERE usuario = ?");
                    $param->bind_param('s', $aluno);
                    if ($param->execute()) {
                      echo "<div class='alert alert-warning'> Aluno " .  $aluno . " removido do grupo " . $idGrupo .". </div>";
                      $param->close();
                    }
                  }
                }
              }
            endif;
          ?>


        <tr>
            <td>Alunos do grupo <?php echo $idGrupo; ?> </td>
            <td>Alunos sem grupo</td>
        </tr>
        <tr>
            <td>
            <select id="from_select_list" multiple="multiple" name="from_select_list"> 
            <?php
              if($idGrupo){
                if ($sql = $conexao->query("SELECT `usuario`, `nome`, `anos_idAno` FROM `alunos` WHERE `escolas_idEscolas`=".$_SESSION['idEscolas']." AND `grupos_idGrupos`=".$idGrupo)) {
                  $alunoListar = "";
                  while ($linha = $sql->fetch_assoc()){
                    $alunoListar = $alunoListar . " " . $linha['usuario'] ;
                    echo '<option value="'.$linha['usuario'].'">' . $linha['nome'] . '-'. $linha['anos_idAno'] . '  ano </option>';
                  }
                }
              }
            ?>
            </select>
          </td>
          <td>
            <select id="to_select_list" multiple="multiple" name="to_select_list"> 
            <?php
              include 'restrito/conexao.php';
              $idGrupo = htmlspecialchars($_GET["grupo"]);
              if($idGrupo){
                if ($sql = $conexao->query("SELECT `usuario`, `nome`, `anos_idAno` FROM `alunos` WHERE `escolas_idEscolas`=".$_SESSION['idEscolas']." AND `grupos_idGrupos`=999999")) {
                  while ($linha = $sql->fetch_assoc()){
                    echo '<option value="'.$linha['usuario'].'">' . $linha['nome'] . '-'. $linha['anos_idAno'] . '  ano </option>';
                  }
                }
              }
            ?>
            </select>
          </td>
        </tr>
        <tr>
            <td>
              <p><input id="moveright" type="button" value="Remover do grupo" onclick="move_list_items('from_select_list','to_select_list');" /></p>
            </td>
            <td>
              <p><input id="moveleft" type="button" value="Adicionar ao grupo" onclick="move_list_items('to_select_list','from_select_list');" /></p>
            </td>
          </tr>
        <tr>
            <td colspan="2">
              <p>
                <form action="" method="POST" id="salvaAlunosNoGrupo" name="salvaAlunosNoGrupo">
                  <input id="salvarAlunosGrupoInput" name="salvarAlunosGrupoInput" type="submit" value="Salvar alteração de alunos" />
                  <input type="hidden" name="listaAlunosAntiga" id="listaAlunosAntiga" value=" <?php echo $alunoListar ?> " />
                  <input type="hidden" name="listaAlunosNova" id="listaAlunosNova" value=" <?php echo $alunoListar ?> " />
                </form>
              </p>
            </td>
          </tr>
       </table>
    </div>  
<?php include 'templates/footer.php' ?>
