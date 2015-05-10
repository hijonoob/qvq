<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> Remoção de escolas </h3>
			<?php
			
				include 'restrito/conexao.php';
				$idEscolas = htmlspecialchars($_GET["id"]);
				if($idEscolas){
					if ($sql = $conexao->prepare("SELECT nome FROM escolas WHERE idEscolas = ?")) {
						$sql->bind_param('i', $idEscolas);
						$sql->execute();
						$sql->bind_result($nome);
						$sql->fetch();
						$sql->close();
						if ($nome == ''){
							echo "<div class='alert alert-warning'> Escola não encontrada </div>";
						} else {
								if ($sql = $conexao->prepare("DELETE FROM escolas WHERE idEscolas=?")) {
									$sql->bind_param('i', $idEscolas);
									$sql->execute();
									$sql->close();
									echo "<div class='alert alert-success'> Escola removida </div>";
								} else {
									echo "<div class='alert alert-danger'> Erro ao deletar escola </div>";
								}
						}
					}
				} else {
					echo "<div class='alert alert-warning'> Escola não encontrada </div>";
				}
			 ?>
		</div>

<?php include 'templates/footer.php' ?>

