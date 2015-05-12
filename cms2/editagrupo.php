
<?php
  include 'templates/checagestor.php';
  include 'templates/header.php';
  $idGrupo = htmlspecialchars($_GET["grupo"]);
?>
<script language="javascript" type="text/javascript">
    /* Author :: Dharmendra Patri | Email :: dharam.new@gmail.com | Site :: http://lovewithbug.com | http://forthera.com */
    function move_list_items(sourceid, destinationid) { $("#"+sourceid+"  option:selected").appendTo("#"+destinationid); }
  function move_list_items_all(sourceid, destinationid) { $("#"+sourceid+" option").appendTo("#"+destinationid); }
    function salvarAlunosGrupo() { console.log("Salvar"); }

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

        <tr>
            <td>Alunos do grupo <?php echo $idGrupo; ?> </td>
            <td>Alunos sem grupo</td>
        </tr>
        <tr>
            <td>
            <select id="from_select_list" multiple="multiple" name="from_select_list"> 
            <?php
              include 'restrito/conexao.php';
              if($idGrupo){
                if ($sql = $conexao->query("SELECT `usuario`, `nome`, `anos_idAno` FROM `alunos` WHERE `escolas_idEscolas`=".$_SESSION['idEscolas']." AND `grupos_idGrupos`=".$idGrupo)) {
                  while ($linha = $sql->fetch_assoc()){
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
              <p><input id="salvarAlunosGrupo" type="button" value="Salvar alteração de alunos" onclick="salvarAlunosGrupo();" /></p>
            </td>
          </tr>
       </table>
    </div>  
<?php include 'templates/footer.php' ?>
