<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
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
			<h3> Criar grupo </h3>
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
					echo "<p> </p>"
				?>




     <table>

        <tr>
            <td>Adicione professores nesse grupo </td>
            <td>Professores para adicionar</td>
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



