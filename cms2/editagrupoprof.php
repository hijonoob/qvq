<?php
  include 'templates/checagestor.php';
  include 'templates/header.php';
  $idGrupo = htmlspecialchars($_GET["grupo"]);
?>
<script language="javascript" type="text/javascript">
    /* Author :: Dharmendra Patri | Email :: dharam.new@gmail.com | Site :: http://lovewithbug.com | http://forthera.com */
    function move_list_items(sourceid, destinationid) {
      var professores = "";
      $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
      $("#from_select_list option").each(function()
      {
          professores =  professores + " " + $(this).val();
      });
      $("#listaProfessoresNova").val(professores);
    }
    function move_list_items_all(sourceid, destinationid) {
      var professores = "";
      $("#"+sourceid+" option").appendTo("#"+destinationid);
      $("#from_select_list option").each(function()
      {
          professores =  professores + " " + $(this).val();
      });
      $("#listaProfessoresNova").val(professores);
    }
</script>
<style>
  select#from_select_list { width: 90%;}
  select#to_select_list { width: 90%; }
  table { width: 100%; }
  tr { width: 100%; }
  td { width: 50%; }
</style>

      <h3> Editar Professores do Grupo <?php echo $idGrupo; ?> </h3>
      <table>

        <?php
          include 'restrito/conexao.php';
          if( isset( $_POST['salvarAlunosGrupoInput'] ) ):
              $listaProfessoresNova = trim($_POST['listaProfessoresNova']);
              $listaProfessoresAntiga = trim($_POST['listaProfessoresAntiga']);
              
              if ($listaProfessoresAntiga=='' || $listaProfessoresNova=='') {
                echo "<div class='alert alert-warning'> Erro ao salvar dados - Não permitido remover todos os professores. </div>";
              } else if ($listaProfessoresAntiga == $listaProfessoresNova) 
                echo "<div class='alert alert-warning'> Não houve alteração no grupo. </div>";
              else {
                $listProfAnt = explode(" ", $listaProfessoresAntiga);
                $listProfNov = explode(" ", $listaProfessoresNova);
                // Encontra itens novos
                foreach ($listProfNov as &$prof) {
                  if (!in_array($prof, $listProfAnt)) { 
                      $param = $conexao->prepare('INSERT INTO ProfGrupos(professores_usuario, grupos_idGrupos) VALUES (?, ?)');
                      $param->bind_param('ss', $prof, $idGrupo);
                      if ($param->execute()) {
                        echo "<div class='alert alert-success'> Professor " .  $prof . " adicionado ao grupo " . $idGrupo ." </div>";
                        $param->close();
                      } 

                  }
                }
                // Encontra itens removidos
                foreach ($listProfAnt as &$prof) {
                  if (!in_array($prof, $listProfNov)) { 
                    if ($sql = $conexao->prepare("DELETE FROM ProfGrupos WHERE professores_usuario=?")) {
                      $sql->bind_param('s', $prof);
                      $sql->execute();
                      $sql->close();
                      echo "<div class='alert alert-warning'> Professor " . $prof . " removido do grupo " .  $idGrupo ." </div>";
                    }
                  }
                }
              }
            endif;
          ?>

        <tr>
            <td>Professores do grupo <?php echo $idGrupo; ?> </td>
            <td>Professores sem grupo</td>
        </tr>
        <tr>
            <td>
            <select id="from_select_list" multiple="multiple" name="from_select_list"> 
            <?php
              if($idGrupo){
                $resultado = $conexao->query("
                        SELECT professores_usuario
                        FROM ProfGrupos
                        WHERE `grupos_idGrupos` =" . $idGrupo . "
                        LIMIT 0 , 100");
                $professores = "";
                $profListar = "";
                $sep="";
                while ($linha = $resultado->fetch_assoc()){
                        $professores = $professores . $sep . "'" . $linha['professores_usuario'] . "'";
                        $profListar = $profListar . " " . $linha['professores_usuario'] ;
                        $sep=", ";
                }

                $resultado = $conexao->query("
                        SELECT usuario, nome
                        FROM professores
                        WHERE `usuario` IN(" . $professores . ")
                        GROUP BY `usuario`
                        LIMIT 0 , 100");

                while ($linha = $resultado->fetch_assoc()){
                        echo '<option value="'.$linha['usuario'].'">' . $linha['nome'] . '</option>';
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
                if ($sql = $conexao->query("
                    SELECT `usuario`, `nome`
                    FROM `professores`
                    WHERE `escolas_idEscolas`=".$_SESSION['idEscolas']. " AND `usuario` NOT IN (" . $professores . ")
                    ")) {

                  while ($linha = $sql->fetch_assoc()){
                    echo '<option value="'.$linha['usuario'].'">' . $linha['nome'] . '</option>';
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
                <form action="" method="POST" id="salvaProfessoresNoGrupo" name="salvaProfessoresNoGrupo">
                  <input id="salvarAlunosGrupoInput" name="salvarAlunosGrupoInput" type="submit" value="Salvar alteração de professores" />
                  <input type="hidden" name="listaProfessoresAntiga" id="listaProfessoresAntiga" value=" <?php echo $profListar ?> " />
                  <input type="hidden" name="listaProfessoresNova" id="listaProfessoresNova" value=" <?php echo $profListar ?> " />
                </form>
              </p>
            </td>
          </tr>
       </table>
    </div>  
<?php include 'templates/footer.php' ?>
