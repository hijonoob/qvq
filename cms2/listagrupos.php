<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> Lista grupos </h3>
			<table class="table table-striped" width="647">
				<thead>
					<tr>
						<th>Grupo ID</th>
						<th>Editar</th>
					</tr>
				</thead>
				<tbody>
				<?php
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
  						  echo '<tr>';
						  echo '<td>' . $linha['idGrupo'] . '</td>';
						  echo '<td> <a href="editagrupo.php?grupo='. $linha['idGrupo'].'">Editar</a></td>';
						  echo '</tr>';
                                                }
					}
				?>
				</tbody>
				</table>
		</div>	
<?php include 'templates/footer.php' ?>


