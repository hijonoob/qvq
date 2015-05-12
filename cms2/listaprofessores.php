<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> Lista professores </h3>
			<table class="table table-striped" width="647">
				<thead>
					<tr>
						<th>Usuário</th>
						<th>Nome</th>
						<th>Perg Criadas</th>
						<th>Pontos</th>
						<th>Editar</th>
						<th>Remover</th>
					</tr>
				</thead>
				<tbody>
				<?php
					include 'restrito/conexao.php';

                                                $resultado = $conexao->query("SELECT usuario, nome, qtPergCriad, pontos FROM professores  WHERE `escolas_idEscolas`=".$_SESSION['idEscolas']." ORDER BY usuario");
					while ($linha = $resultado->fetch_assoc()){
						echo '<tr>';
						echo '<td>' . $linha['usuario'] . '</td>';
						echo '<td>' . $linha['nome'] .' </td>';
						echo '<td>' . $linha['qtPergCriad'] .'</td>';
						echo '<td>' . $linha['pontos'] .'</td>';
						echo '<td> <a href="editaprofessor.php?usuario='. $linha['usuario'].'">Editar</a></td>';
						echo '<td> <a class="removeprofessor" href="deletaprofessor.php?usuario='. $linha['usuario'].'">X</a></td>';
						echo '</tr>';
					}
				?>
				</tbody>
				</table>
		</div>	
<?php include 'templates/footer.php' ?>

