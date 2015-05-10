<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> Lista escolas </h3>
			<table class="table table-striped" width="647">
				<thead>
					<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Contato</th>
						<th>Telefone</th>
						<th>Editar</th>
						<th>Remover</th>
					</tr>
				</thead>
				<tbody>
				<?php
					include 'restrito/conexao.php';
						$resultado = $conexao->query("SELECT idEscolas, nome, contato, telFixo FROM escolas ORDER BY idEscolas");
					while ($linha = $resultado->fetch_assoc()){
						echo '<tr>';
						echo '<td>' . $linha['idEscolas'] . '</td>';
						echo '<td>' . $linha['nome'] .' </td>';
						echo '<td>' . $linha['contato'] .'</td>';
						echo '<td>' . $linha['telFixo'] .'</td>';
						echo '<td> <a href="editaescola.php?id='. $linha['idEscolas'].'">Editar</a></td>';
						echo '<td> <a class="removeescola" href="deletaescola.php?id='. $linha['idEscolas'].'">X</a></td>';
						echo '</tr>';
					}
				?>
				</tbody>
				</table>
		</div>	
<?php include 'templates/footer.php' ?>

