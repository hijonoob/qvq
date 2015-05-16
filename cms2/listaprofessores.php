<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> <?php echo _( 'List teachers'); ?> </h3>
			<table class="table table-striped" width="647">
				<thead>
					<tr>
						<th><?php echo _( 'User'); ?></th>
						<th><?php echo _( 'Name'); ?></th>
						<th><?php echo _( 'Created questions'); ?></th>
						<th><?php echo _( 'Score'); ?></th>
						<th><?php echo _( 'Edit'); ?></th>
						<th><?php echo _( 'Remove'); ?></th>
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
						echo '<td> <a href="editaprofessor.php?usuario='. $linha['usuario'].'">' . _( 'Edit') . '</a></td>';
						echo '<td> <a class="removeprofessor" href="deletaprofessor.php?usuario='. $linha['usuario'].'">X</a></td>';
						echo '</tr>';
					}
				?>
				</tbody>
				</table>
		</div>	
<?php include 'templates/footer.php' ?>

