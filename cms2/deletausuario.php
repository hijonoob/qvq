<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> Remoção de usuário </h3>
			<?php
			
				include 'restrito/conexao.php';
				$usuario = htmlspecialchars($_GET["user"]);
				if($usuario){
					if ($sql = $conexao->prepare("SELECT nome, usuario FROM usuarios WHERE usuario = ?")) {
						$sql->bind_param('s', $usuario);
						$sql->execute();
						$sql->bind_result($nome, $usuario);
						$sql->fetch();
						$sql->close();
						if ($nome == ''){
							echo "<div class='alert alert-warning'> Usuário não encontrado </div>";
						} else {
								if ($sql = $conexao->prepare("DELETE FROM usuarios WHERE usuario=?")) {
									$sql->bind_param('s', $usuario);
									$sql->execute();
									$sql->close();
									echo "<div class='alert alert-success'> Usuário removido </div>";
								} else {
									echo "<div class='alert alert-danger'> Erro ao deletar usuário </div>";
								}
						}
					}
				} else {
					echo "<div class='alert alert-warning'> Usuário não encontrado </div>";
				}
			 ?>
		</div>

<?php include 'templates/footer.php' ?>