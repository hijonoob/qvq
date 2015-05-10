<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> Remoção de alunos </h3>
			<?php
			
				include 'restrito/conexao.php';
				$usuario = htmlspecialchars($_GET["usuario"]);
				if($usuario){
					if ($sql = $conexao->prepare("SELECT nome FROM alunos WHERE usuario = ?")) {
						$sql->bind_param('i', $usuario);
						$sql->execute();
						$sql->bind_result($nome);
						$sql->fetch();
						$sql->close();
						if ($nome == ''){
							echo "<div class='alert alert-warning'> Usuário não encontrado </div>";
						} else {
								if ($sql = $conexao->prepare("DELETE FROM alunos WHERE usuario=?")) {
									$sql->bind_param('i', $usuario);
									$sql->execute();
									$sql->close();
									echo "<div class='alert alert-success'> Aluno removido </div>";
								} else {
									echo "<div class='alert alert-danger'> Erro ao deletar aluno </div>";
								}
						}
					}
				} else {
					echo "<div class='alert alert-warning'> Aluno não encontrado </div>";
				}
			 ?>
		</div>

<?php include 'templates/footer.php' ?>
