<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3><?php echo _( 'Add teacher'); ?> </h3>
			
			<?php
				include 'restrito/conexao.php';
				if( isset( $_POST['criar'] ) ):
					$usuario = $_POST['usuario'];
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
                                                $hoje = date("Y-m-d");
						$param = $conexao->prepare("INSERT INTO professores(usuario, nome, dtNasc, email, telFixo, telCel, end, cid, est, cep, senha, escolas_idEscolas, dtReg, dtUltAces, pontos, qtPergCriad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0)");
						$param->bind_param('ssisiisssssiss', $usuario, $nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $_SESSION['idEscolas'], $hoje, $hoje);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> " . _( 'Added successfully') . "  </div>";
							$param->close();
						}
					}
				endif;
			?>
			
			
			<form action="" method="POST" id="adicionprof">
				<label for="usuario"> <?php echo _( 'User'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'login username'); ?>" class="form-control" name="usuario" autofocus />
				<label for="nome"> <?php echo _( 'Name'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'name'); ?>" class="form-control" name="nome" />
				<label for="dtNasc"> <?php echo _( 'Birth date'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'birth date'); ?>" class="form-control" name="dtNasc" />
				<label for="email"> E-mail: </label>
					<input type="text" placeholder="e-mail" class="form-control" name="email" />
				<label for="telFixo"> <?php echo _( 'Phone'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'phone number'); ?>" class="form-control" name="telFixo" />
				<label for="telCel"> <?php echo _( 'Mobile phone'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'mobile phone number'); ?>" class="form-control" name="telCel" />
				<label for="end"> <?php echo _( 'Address'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'full address'); ?>" class="form-control" name="end" />
				<label for="cid"> <?php echo _( 'City'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'city'); ?>" class="form-control" name="cid" />
				<label for="est"> <?php echo _( 'State'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'state'); ?>" class="form-control" name="est" />
				<label for="cep"> <?php echo _( 'Zip code'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'zip code'); ?>" class="form-control" name="cep" />
				<label for="senha"> <?php echo _( 'Password'); ?>: </label>
					<input type="text" placeholder="<?php echo _( 'login access password'); ?>" class="form-control" name="senha" />

				<input type="submit" name="criar" value="<?php echo _( 'Add teacher'); ?>r" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>

