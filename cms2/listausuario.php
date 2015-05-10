<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> Lista usuários </h3>
			<table class="table table-striped" width="647">
				<thead>
					<tr>
						<th>#</th>
						<th>Nome</th>
						<th>Usuário</th>
						<th>Permissão</th>
						<th>Editar</th>
						<th>Remover</th>
					</tr>
				</thead>
				<tbody>
			<?php
				include 'restrito/conexao.php';
					$resultado = $conexao->query("SELECT nome, usuario, permissao FROM usuarios");
				$i = 1;
				while ($linha = $resultado->fetch_assoc()){
					echo '<tr>';
					echo '<td>' . $i . '</td>'; // colocar número de repetição
					echo '<td>' . $linha['nome'] .'</td>';
					echo '<td>' . $linha['usuario'] .'</td>';
					echo '<td>' . $linha['permissao'] .'</td>';
					echo '<td> <a href="editausuario.php?user='. $linha['usuario'].'">Editar</a></td>';
					echo '<td> <a class="removeusuario" href="deletausuario.php?user='. $linha['usuario'].'">X</a></td>';
					echo '</tr>';
					$i++;

				}
			?>
					</tbody>
				</table>
		</div>
<?php include 'templates/footer.php' ?>