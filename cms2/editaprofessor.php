<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> <?php echo _( 'Edit teacher'); ?> </h3>
			
			<?php
				include 'restrito/conexao.php';
				$usuario = htmlspecialchars($_GET["usuario"]);
				if($usuario){
					if ($sql = $conexao->prepare("SELECT nome, dtNasc, email, telFixo, telCel, end, cid, est, cep, senha FROM professores WHERE usuario = ?")) {
						$sql->bind_param('s', $usuario);
						$sql->execute();
						$sql->bind_result($nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha);
						$sql->fetch();
						if ($nome == ''){
							echo "<div class='alert alert-warning'> " . _( 'Teacher not found ') . " </div>";
						} else {
							echo "<div class='alert alert-info'> " . _( 'Teacher found: USER ') . " ". $usuario . "</div>";
						}
						$sql->close();
					}
				}
				
				if( isset( $_POST['editar'] ) ):
					$nome = $_POST['nome'];
					$dtNasc = $_POST['dtNasc'];
					$email = $_POST['email'];
					$telFixo = $_POST['telFixo'];
					$telCel = $_POST['telCel'];
					$end = $_POST['end'];
					$cid = $_POST['cid'];
					$est = $_POST['est'];
					$cep = $_POST['cep'];
					$senha = $_POST['senha'];
					
					if ($usuario=='' || $nome=='' || $dtNasc=='' || $email=='' || $telFixo=='' ||  $telCel=='' || $end=='' || $cid=='' || $est=='' || $cep=='' || $senha=='') {
						echo "<div class='alert alert-warning'> " . _( 'All fields must be typed') . " </div>";
					} else {
						$param = $conexao->prepare("UPDATE professores SET nome = ?, dtNasc = ?, email = ?, telFixo = ?, telCel = ?, end = ?, cid = ?, est = ?, cep = ?, senha = ? WHERE usuario = ?");
						$param->bind_param('sisiissssss', $nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $usuario);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> " . _( 'Changed successfully') . " </div>";
							$param->close();
						}
					}
				endif;
			?>

			<form action="" method="POST" id="editaprofessor">
				<label for="nome"> <?php echo _( 'Name'); ?>: </label>
					<input type="text" placeholder="nome" class="form-control" name="nome" value=<?php echo "'". $nome . "'"; ?>/>
				<label for="dtNasc"> <?php echo _( 'Birth date'); ?>: </label>
					<input type="text" placeholder="data de nascimento" class="form-control" name="dtNasc" value=<?php echo "'". $dtNasc . "'"; ?>/>
				<label for="email"> E-mail: </label>
					<input type="text" placeholder="e-mail" class="form-control" name="email" value=<?php echo "'". $email . "'"; ?>/>
				<label for="telFixo"> <?php echo _( 'Phone'); ?>: </label>
					<input type="text" placeholder="telefone fixo" class="form-control" name="telFixo" value=<?php echo "'". $telFixo . "'"; ?>/>
				<label for="telCel"> <?php echo _( 'Mobile Phone'); ?>: </label>
					<input type="text" placeholder="telefone celular" class="form-control" name="telCel" value=<?php echo "'". $telCel . "'"; ?>/>
				<label for="end"> <?php echo _( 'Address'); ?>: </label>
					<input type="text" placeholder="endereço completo" class="form-control" name="end" value=<?php echo "'". $end . "'"; ?>/>
				<label for="cid"> <?php echo _( 'City'); ?>: </label>
					<input type="text" placeholder="cidade" class="form-control" name="cid" value=<?php echo "'". $cid . "'"; ?>/>
				<label for="est"> <?php echo _( 'State'); ?>: </label>
					<input type="text" placeholder="estado" class="form-control" name="est" value=<?php echo "'". $est . "'"; ?>/>
				<label for="cep"> <?php echo _( 'Zip Code'); ?>: </label>
					<input type="text" placeholder="cep" class="form-control" name="cep" value=<?php echo "'". $cep . "'"; ?> />
				<label for="senha"> <?php echo _( 'Password'); ?>: </label>
					<input type="text" placeholder="senha para acesso de login" class="form-control" name="senha" value=<?php echo "'". $senha . "'"; ?>/>


				<input type="submit" name="editar" value="<?php echo _( 'Edit teacher'); ?>" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>

