<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> <?php echo _( 'Edit school'); ?> </h3>
			
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
							echo "<div class='alert alert-warning'> " . _( 'School not found') . " </div>";
						} else {
							echo "<div class='alert alert-info'> " . _( 'School found: ID ') . "". $idEscolas . "</div>";
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
						echo "<div class='alert alert-warning'> " . _( 'All data must be typed') . " </div>";
					} else {
						$param = $conexao->prepare("UPDATE escolas SET usuario = ?, perfil = ?, nome = ?, razao = ?, cnpj = ?, end = ?, cid = ?, est = ?, cep = ?, telFixo = ?, contato = ?, senha = ? WHERE idEscolas = ?");
						$param->bind_param('ssssssssiissi', $usuario, $perfil, $nome, $razao, $cnpj, $end, $cid, $est, $cep, $telFixo, $contato, $senha, $idEscolas);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> " . _( 'Changed successfully') . " </div>";
							$param->close();
						}
					}
				endif;
			?>

			<form action="" method="POST" id="editaescola">
				<label for="usuario"> <?php echo _( 'User'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'login user'); ?>" class="form-control" name="usuario" value=<?php echo "'". $usuario . "'"; ?> autofocus />
				<label for="perfil"> <?php echo _( 'Profile'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'access profile, 2 to school, 3 to admin'); ?>" class="form-control" name="perfil" value=<?php echo "'". $perfil . "'"; ?>/>
				<label for="nome"> <?php echo _( 'Name'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'school name'); ?>" class="form-control" name="nome" value=<?php echo "'". $nome . "'"; ?> />
				<label for="razao"> <?php echo _( 'Registered Name'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'registered name of the school'); ?>" class="form-control" name="razao" value=<?php echo "'". $razao . "'"; ?> />
				<label for="cnpj"> <?php echo _( 'Registered Number'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'registered number of the school'); ?> " class="form-control" name="cnpj" value=<?php echo "'". $cnpj . "'"; ?>/>
				<label for="end"> <?php echo _( 'Address'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'complete address of the school'); ?> " class="form-control" name="end" value=<?php echo "'". $end . "'"; ?>/>
				<label for="cid"> <?php echo _( 'City'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'city of the school'); ?> " class="form-control" name="cid" value=<?php echo "'". $cid . "'"; ?>/>
				<label for="est"> <?php echo _( 'State'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'state of the school'); ?> " class="form-control" name="est" value=<?php echo "'". $est . "'"; ?>/>
				<label for="cep"> <?php echo _( 'Zip Code'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'zip code of the school'); ?> " class="form-control" name="cep" value=<?php echo "'". $cep . "'"; ?> />
				<label for="telFixo"> <?php echo _( 'Phone'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'phone of the school'); ?> " class="form-control" name="telFixo" value=<?php echo "'". $telFixo . "'"; ?>/>
				<label for="contato"> <?php echo _( 'Contact'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'contact name to talk to the school'); ?> " class="form-control" name="contato" value=<?php echo "'". $contato . "'"; ?>/>
				<label for="senha"> <?php echo _( 'Password'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'login access password'); ?> s" class="form-control" name="senha" value=<?php echo "'". $senha . "'"; ?>/>
				<input type="submit" name="editar" value="<?php echo  _( 'Edit school'); ?> "" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>
