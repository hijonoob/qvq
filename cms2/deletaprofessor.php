<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> Remoção de professores </h3>
			<?php
			
				include 'restrito/conexao.php';
				$usuario = htmlspecialchars($_GET["usuario"]);
				if($usuario){
					if ($sql = $conexao->prepare("SELECT nome FROM professores WHERE usuario = ?")) {
						$sql->bind_param('i', $usuario);
						$sql->execute();
						$sql->bind_result($nome);
						$sql->fetch();
						$sql->close();
						if ($nome == ''){
							echo "<div class='alert alert-warning'> Usuário não encontrado </div>";
						} else {
								if ($sql = $conexao->prepare("DELETE FROM professores WHERE usuario=?")) {
									$sql->bind_param('s', $usuario);
									$sql->execute();
									$sql->close();
									echo "<div class='alert alert-success'> Professor removido </div>";
								} else {
									echo "<div class='alert alert-danger'> Erro ao deletar professor </div>";
								}
						}
					}
				} else {
					echo "<div class='alert alert-warning'> Professor não encontrado </div>";
				}
			 ?>
		</div>

<?php include 'templates/footer.php' ?>

