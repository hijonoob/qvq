<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> <?php echo _( 'List groups'); ?> </h3>
			<table class="table table-striped" width="647">
				<thead>
					<tr>
						<th><?php echo _( 'Group ID'); ?></th>
						<th><?php echo _( 'Edit teacher'); ?></th>
						<th><?php echo _( 'Edit student'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
					include 'restrito/conexao.php';
					$resultado = $conexao->query("
						SELECT usuario, escolas_idEscolas
						FROM professores
						WHERE `escolas_idEscolas`=".$_SESSION['idEscolas']."
						GROUP BY `usuario`
						LIMIT 0 , 100");
					$professores = "";
					$sep="";
					while ($linha = $resultado->fetch_assoc()){
						$professores = $professores . $sep . "'" . $linha['usuario'] . "'";
						$sep=", ";
					}
					$resultado = $conexao->query("
						SELECT grupos_idGrupos
						FROM ProfGrupos
						WHERE `professores_usuario` IN(" . $professores . ")
						GROUP BY `grupos_idGrupos`
						LIMIT 0 , 100");
					$professoresId = "";
					$sep="";
					while ($linha = $resultado->fetch_assoc()){
						$professoresId = $professoresId . $sep . $linha['grupos_idGrupos'];
						$sep=", ";
					}
					$resultado = $conexao->query("
						SELECT idGrupo
						FROM (
						SELECT u.grupos_idGrupos AS idGrupo
						FROM ProfGrupos u
						WHERE u.professores_usuario IN(" . $professores . ")
						GROUP BY u.grupos_idGrupos
						LIMIT 0 , 100
						UNION ALL 
						SELECT a.grupos_idGrupos AS idGrupo
						FROM alunos a
						WHERE `escolas_idEscolas`=".$_SESSION['idEscolas']."
						GROUP BY a.grupos_idGrupos
						LIMIT 0 , 100
						)t
						GROUP BY idGrupo");
					while ($linha = $resultado->fetch_assoc()){
                        if($linha['idGrupo']!=999999){
  						  echo '<tr>';
						  echo '<td>' . $linha['idGrupo'] . '</td>';
						  echo '<td> <a href="editagrupoprof.php?grupo='. $linha['idGrupo'].'">' . _( 'Edit') . '</a></td>';
						  echo '<td> <a href="editagrupoaluno.php?grupo='. $linha['idGrupo'].'">' . _( 'Edit') . '</a></td>';
						  echo '</tr>';
                        }
					}
				?>
				</tbody>
				</table>
		</div>	
<?php include 'templates/footer.php' ?>



