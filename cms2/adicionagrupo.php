<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
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
			<h3> <?php echo _( 'Add Group'); ?> </h3>
				<?php
					$maior = 0;
					include 'restrito/conexao.php';
						$resultado = $conexao->query("
							SELECT idGrupo
							FROM (
							SELECT u.grupos_idGrupos AS idGrupo
							FROM ProfGrupos u
							GROUP BY u.grupos_idGrupos
							LIMIT 0 , 100
							UNION ALL 
							SELECT a.grupos_idGrupos AS idGrupo
							FROM alunos a
							GROUP BY a.grupos_idGrupos
							LIMIT 0 , 100
							)t
							GROUP BY idGrupo");
					while ($linha = $resultado->fetch_assoc()){
                          if($linha['idGrupo']!=999999){
                          	$maior = $linha['idGrupo'];
                          }
					}
					$maior++;
					echo "<h2> Grupo: ". $maior ."</h2>";
          // salva o novo grupo com os professores da lista
          if( isset( $_POST['salvarProfessorNoGrpo'] ) ):
              $listaProfessoresNova = trim($_POST['listaProfessoresNova']);
              if ($listaProfessoresNova=='') {
                echo "<div class='alert alert-warning'> " . _( 'Error saving data - At least one teacher must be added') . " </div>";
              } else {
                $listProfNov = explode(" ", $listaProfessoresNova);
                // Encontra itens novos
                foreach ($listProfNov as &$prof) {
                  $param = $conexao->prepare('INSERT INTO ProfGrupos(professores_usuario, grupos_idGrupos) VALUES (?, ?)');
                  $param->bind_param('ss', $prof, $maior);
                  if ($param->execute()) {
                    echo "<div class='alert alert-success'> " . _( 'Teacher') . " " .  $prof . " " . _( 'added to the group') . " " . $maior ." </div>";
                    $param->close();
                  } else {
                    echo "<div class='alert alert-success'> " . _( 'Error adding teacher') . " " .  $prof . " " . _( 'to the group') . " </div>";
                  }
                }
              }
            endif;
          ?>

     <table>

        <tr>
            <td> <?php echo _( 'Add teacher to this group'); ?> </td>
            <td> <?php echo _( 'Teachers to add'); ?> </td>
        </tr>
        <tr>
            <td>
            <select id="from_select_list" multiple="multiple" name="from_select_list"> 
            </select>
          </td>
          <td>
            <select id="to_select_list" multiple="multiple" name="to_select_list"> 
            <?php
              include 'restrito/conexao.php';
	            if ($sql = $conexao->query("SELECT `usuario`,`nome` FROM `professores` WHERE `escolas_idEscolas`=".$_SESSION['idEscolas'])) {
	              while ($linha = $sql->fetch_assoc()){
	                echo '<option value="'.$linha['usuario'].'">' . $linha['nome'] . '</option>';
	              }
	            }
            ?>
            </select>
            <?php echo $_SESSION['idEscolas']; ?>
          </td>
        </tr>
        <tr>
            <td>
              <p><input id="moveright" type="button" value="<?php echo _( 'Remove from group'); ?> " onclick="move_list_items('from_select_list','to_select_list');" /></p>
            </td>
            <td>
              <p><input id="moveleft" type="button" value="<?php echo _( 'Add to group'); ?> " onclick="move_list_items('to_select_list','from_select_list');" /></p>
            </td>
          </tr>
        <tr>
            <td colspan="2">
              <p>
                <form action="" method="POST" id="salvaProfessoresNoGrupo" name="salvaProfessoresNoGrupo">
                  <input id="salvarProfessorNoGrpo" name="salvarProfessorNoGrpo" type="submit" value="<?php echo _( 'Add group with teachers'); ?> " />
                  <input type="hidden" name="listaProfessoresNova" id="listaProfessoresNova" value=" " />
                </form>
              </p>
            </td>
          </tr>
       </table>



		</div>	
<?php include 'templates/footer.php' ?>
