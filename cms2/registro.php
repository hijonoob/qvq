<?php
	include 'templates/header.php';
?>
			<h3> Cadastre-se no site do Beetle Escape </h3>
			<p> O jogador cadastrado no site do Beetle Escape possui acesso a conteúdo extra, informações relevantes e direito a voto. </p>
			
			<?php
				include 'restrito/conexao.php';
				
				if( isset( $_POST['registra'] ) ):
					$usuario = $_POST['usuario']; 
					$nome = $_POST['nome'];
					$email = $_POST['email'];
					$senha = $_POST['senha'];
					$senhaconfirma = $_POST['senhaconfirma'];
					$permissao = 0;
					// validação de captcha
					include_once 'securimage/securimage.php';
					$securimage = new Securimage();
					if ($securimage->check($_POST['captcha_code']) == false) {
					// captcha errado
					echo "<div class='alert alert-warning'> Captcha incorreto, favor tentar novamente. </div>";
					} else {
						// CAPTCHA CORRETO
						if ($usuario=='' || $nome=='' || $email=='' || $senha=='' || $senhaconfirma=='') {
							echo "<div class='alert alert-warning'> Todos os campos devem ser preenchidos. </div>";
						} else if (!$senha == $senhaconfirma){
							echo "<div class='alert alert-warning'> Senha de confirmação diferente da senha. </div>";
						} else {
							if ($sql = $conexao->prepare("SELECT nome FROM usuarios WHERE usuario = ?")) {
								$sql->bind_param('s', $usuario);
								$sql->execute();
								$sql->bind_result($nomeBase);
								$sql->fetch();
								$sql->close();
								if ($nomeBase == ''){
									$param = $conexao->prepare("INSERT INTO usuarios(usuario, nome, email, senha, permissao) VALUES (?, ?, ?, ?, ?)");
									// criptografa a senha
									$senha = crypt($senha);
									$param->bind_param('ssssi', $usuario, $nome, $email, $senha, $permissao);
									if ($param->execute()) {
										echo "<div class='alert alert-success'> Inclusão efetuada com sucesso. </div>";
										$param->close();
									}
								} else {
									echo "<div class='alert alert-warning'> Usuário já existente, favor escolher outro usuário </div>";
								}
							}
						}
					}
				endif;
			?>
			
			
			<form action="" method="POST" id="registro">
			<?php if($usuario=='root'){$usuario='';} ?>
				<label> Usuário: </label>
					<input type="text" placeholder="usuário" class="form-control" name="usuario" value=<?php echo "'". $usuario . "'"; ?> autofocus />
				<label> Nome: </label>
					<input type="text" placeholder="nome completo" class="form-control" value=<?php echo "'". $nome . "'"; ?> name="nome" />
				<label> E-mail: </label>
				<input type="text" placeholder="e-mail" class="form-control" value=<?php echo "'". $email . "'"; ?> name="email" />
				<label> Senha: </label>
					<input type="password" placeholder="senha" class="form-control" name="senha" id="senha" />
				<label> Confirmar senha: </label>
					<input type="password" placeholder="repetir senha" class="form-control" name="senhaconfirma" />
				<div class="form-input login-form">
	              <label for="captchainput">Digite o Captcha</label>
	              <br />
	              <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
	              <br />
	                <input type="text" name="captcha_code" size="10" maxlength="6" />
	                <br />
	                <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">Gerar outra imagem</a>
	            </div>
				<input type="submit" name="registra" value="Registrar usuário" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>