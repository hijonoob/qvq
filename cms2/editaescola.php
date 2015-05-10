<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> Editar escola </h3>
			
			<?php
				include 'restrito/conexao.php';
				$idEscolas = htmlspecialchars($_GET["id"]);
				if($idEscolas){

					if ($sql = $conexao->prepare("SELECT usuario, perfil, nome, razao, cnpj, end, cid, est, cep, telFixo, contato, senha FROM escolas WHERE idEscolas = ?")) {
						$sql->bind_param('i', $idEscolas);
						$sql->execute();
						$sql->bind_result($usuario, $perfil, $nome, $razao, $cnpj, $end, $cid, $est, $cep, $telFixo, $contato, $senha);
						$sql->fetch();
						if ($nome == ''){
							echo "<div class='alert alert-warning'> Escola não encontrada </div>";
						} else {
							echo "<div class='alert alert-info'> Escola encontrada: ID ". $idEscolas . "</div>";
						}
						$sql->close();
					}
				}
				
				if( isset( $_POST['editar'] ) ):
					$usuario = $_POST['usuario'];
					$perfil = $_POST['perfil'];
					$nome = $_POST['nome'];
					$razao = $_POST['razao'];
					$cnpj = $_POST['cnpj'];
					$end = $_POST['end'];
					$cid = $_POST['cid'];
					$est = $_POST['est'];
					$cep = $_POST['cep'];
					$telFixo = $_POST['telFixo'];
					$contato = $_POST['contato'];
					$senha = $_POST['senha'];
					
					if ($usuario=='' || $perfil=='' || $nome=='' || $razao=='' || $cnpj=='' || $end=='' || $cid=='' || $est=='' || $cep=='' || $telFixo=='' || $contato=='' || $senha=='') {
						echo "<div class='alert alert-warning'> Todos os campos devem ser preenchidos. </div>";
					} else {
						$param = $conexao->prepare("UPDATE escolas SET usuario = ?, perfil = ?, nome = ?, razao = ?, cnpj = ?, end = ?, cid = ?, est = ?, cep = ?, telFixo = ?, contato = ?, senha = ? WHERE idEscolas = ?");
						$param->bind_param('ssssssssiissi', $usuario, $perfil, $nome, $razao, $cnpj, $end, $cid, $est, $cep, $telFixo, $contato, $senha, $idEscolas);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> Alteração efetuada com sucesso. </div>";
							$param->close();
						}
					}
				endif;
			?>

			<form action="" method="POST" id="editaescola">
				<label for="usuario"> Usuário: </label>
					<input type="text" placeholder="usuário para login" class="form-control" name="usuario" value=<?php echo "'". $usuario . "'"; ?> autofocus />
				<label for="perfil"> Perfil: </label>
					<input type="text" placeholder="perfil de acesso ao CMS 2 para escola 3 para admin" class="form-control" name="perfil" value=<?php echo "'". $perfil . "'"; ?>/>
				<label for="nome"> Nome: </label>
					<input type="text" placeholder="nome da escola" class="form-control" name="nome" value=<?php echo "'". $nome . "'"; ?> />
				<label for="razao"> Razão social: </label>
					<input type="text" placeholder="razão social da escola" class="form-control" name="razao" value=<?php echo "'". $razao . "'"; ?> />
				<label for="cnpj"> CNPJ: </label>
					<input type="text" placeholder="cnpj da escola" class="form-control" name="cnpj" value=<?php echo "'". $cnpj . "'"; ?>/>
				<label for="end"> Endereço: </label>
					<input type="text" placeholder="endereço completo da escola" class="form-control" name="end" value=<?php echo "'". $end . "'"; ?>/>
				<label for="cid"> Cidade: </label>
					<input type="text" placeholder="cidade da escola" class="form-control" name="cid" value=<?php echo "'". $cid . "'"; ?>/>
				<label for="est"> Estado: </label>
					<input type="text" placeholder="estado da escola" class="form-control" name="est" value=<?php echo "'". $est . "'"; ?>/>
				<label for="cep"> CEP: </label>
					<input type="text" placeholder="cep da escola" class="form-control" name="cep" value=<?php echo "'". $cep . "'"; ?> />
				<label for="telFixo"> Telefone fixo: </label>
					<input type="text" placeholder="telefone fixo da escola" class="form-control" name="telFixo" value=<?php echo "'". $telFixo . "'"; ?>/>
				<label for="contato"> Nome do contato: </label>
					<input type="text" placeholder="nome do contato na escola" class="form-control" name="contato" value=<?php echo "'". $contato . "'"; ?>/>
				<label for="senha"> Senha: </label>
					<input type="text" placeholder="senha para acesso de login da escola" class="form-control" name="senha" value=<?php echo "'". $senha . "'"; ?>/>
				<input type="submit" name="editar" value="Editar escola" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>
