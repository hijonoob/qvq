<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';


echo gettext("A string to be translated would go here");
echo _( 'A string to be translated would go here');


?>
			<h3> <?php echo _( 'List students'); ?> </h3>
			<table class="table table-striped" width="647">
				<thead>
					<tr>
						<th><?php echo _( 'User'); ?></th>
						<th><?php echo _( 'Name'); ?></th>
						<th><?php echo _( 'Grade'); ?></th>
						<th><?php echo _( 'Score'); ?></th>
						<th><?php echo _( 'Edit'); ?></th>
						<th><?php echo _( 'Remove'); ?></th>
					</tr>
				</thead>
				<tbody>
				<?php
					include 'restrito/conexao.php';
                                                $resultado = $conexao->query("SELECT usuario, nome, anos_IdAno, pontos FROM alunos WHERE `escolas_idEscolas`=".$_SESSION['idEscolas']." ORDER BY usuario");
					while ($linha = $resultado->fetch_assoc()){
						echo '<tr>';
						echo '<td>' . $linha['usuario'] . '</td>';
						echo '<td>' . $linha['nome'] .' </td>';
						echo '<td>' . $linha['anos_IdAno'] .'</td>';
						echo '<td>' . $linha['pontos'] .'</td>';
						echo '<td> <a href="editaaluno.php?usuario='. $linha['usuario'].'"> _( "Remove"); </a></td>';
						echo '<td> <a class="removealuno" href="deletaaluno.php?usuario='. $linha['usuario'].'">X</a></td>';
						echo '</tr>';
					}
				?>
				</tbody>
				</table>
		</div>	
<?php include 'templates/footer.php' ?>

