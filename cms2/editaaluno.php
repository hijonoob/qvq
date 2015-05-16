<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> <?php echo _( 'Edit student'); ?> </h3>
			
			<?php
				include 'restrito/conexao.php';
				$usuario = htmlspecialchars($_GET["usuario"]);
				if($usuario){

					if ($sql = $conexao->prepare("SELECT nome, dtNasc, email, telFixo, telCel, end, cid, est, cep, senha, grupos_idGrupos, anos_idAno FROM alunos WHERE usuario = ?")) {
						$sql->bind_param('s', $usuario);
						$sql->execute();
						$sql->bind_result($nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $grupos_idGrupos, $anos_idAno);
						$sql->fetch();
						if ($nome == ''){
							echo "<div class='alert alert-warning'> " . _( 'Student not found') . "</div>";
						} else {
							echo "<div class='alert alert-info'> " . _( 'Student found: USER ') . " ". $usuario . "</div>";
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
					$grupos_idGrupos = $_POST['grupos_idGrupos'];
					$anos_idAno = $_POST['anos_idAno'];
					
					if ($usuario=='' || $nome=='' || $dtNasc=='' || $email=='' || $telFixo=='' ||  $telCel=='' || $end=='' || $cid=='' || $est=='' || $cep=='' || $senha=='' || $grupos_idGrupos=='' || $anos_idAno=='') {
						echo "<div class='alert alert-warning'> " . _( 'All fields must be typed') . " </div>";
					} else {
						$param = $conexao->prepare("UPDATE alunos SET nome = ?, dtNasc = ?, email = ?, telFixo = ?, telCel = ?, end = ?, cid = ?, est = ?, cep = ?, senha = ?, grupos_idGrupos = ?, anos_idAno = ? WHERE usuario = ?");
						$param->bind_param('sisiisssssiis', $nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $grupos_idGrupos, $anos_idAno, $usuario);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> " . _( 'Changed successfully') . " </div>";
							$param->close();
						}
					}
				endif;
			?>

			<form action="" method="POST" id="editaaluno">
				<label for="nome"> <?php echo _( 'Name'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'name'); ?>" class="form-control" name="nome" value=<?php echo "'". $nome . "'"; ?>/>
				<label for="dtNasc"> <?php echo _( 'Birth date'); ?> </label>
					<input type="text" placeholder="<?php echo _( 'birth date'); ?>" class="form-control" name="dtNasc" value=<?php echo "'". $dtNasc . "'"; ?>/>
				<label for="email"> E-mail: </label>
					<input type="text" placeholder="e-mail" class="form-control" name="email" value=<?php echo "'". $email . "'"; ?>/>
				<label for="telFixo"> <?php echo _( 'Phone'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'phone number'); ?>" class="form-control" name="telFixo" value=<?php echo "'". $telFixo . "'"; ?>/>
				<label for="telCel"> <?php echo _( 'Mobile phone'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'mobile phone number'); ?>" class="form-control" name="telCel" value=<?php echo "'". $telCel . "'"; ?>/>
				<label for="end"> <?php echo _( 'Address'); ?> </label>
					<input type="text" placeholder="<?php echo _( 'Address'); ?>" class="form-control" name="end" value=<?php echo "'". $end . "'"; ?>/>
				<label for="cid"> <?php echo _( 'City'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'city'); ?>" class="form-control" name="cid" value=<?php echo "'". $cid . "'"; ?>/>
				<label for="est"> <?php echo _( 'State'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'state'); ?>" class="form-control" name="est" value=<?php echo "'". $est . "'"; ?>/>
				<label for="cep"> <?php echo _( 'Zip code'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'zip code'); ?>" class="form-control" name="cep" value=<?php echo "'". $cep . "'"; ?> />
				<label for="senha"> <?php echo _( 'Password'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'login access password'); ?>" class="form-control" name="senha" value=<?php echo "'". $senha . "'"; ?>/>

				<label for="grupos_idGrupos"> <?php echo _( 'Group ID'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'group id - default to 99999'); ?>" class="form-control" name="grupos_idGrupos" value=<?php echo "'". $grupos_idGrupos . "'"; ?> />
				<label for="anos_idAno"> <?php echo _( 'Grade ID'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'Grade ID  - default to 1'); ?>" class="form-control" name="anos_idAno" value=<?php echo "'". $anos_idAno . "'"; ?>/>


				<input type="submit" name="editar" value="<?php echo _( 'Edit student'); ?>" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>
