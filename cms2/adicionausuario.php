<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> Criar novo usuário </h3>
			
			<?php
				include 'restrito/conexao.php';
				
				if( isset( $_POST['criar'] ) ):
					$usuario = $_POST['usuario']; 
					$nome = $_POST['nome'];
					$email = $_POST['email'];
					$senha = $_POST['senha'];
					$senhaconfirma = $_POST['senhaconfirma'];
					$permissao = $_POST['permissao'];
					
					if ($usuario=='' || $nome=='' || $email=='' || $senha=='' || $senhaconfirma=='' || $permissao=='') {
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
								if (!is_numeric ($permissao) || $permissao > 3 || $permissao < 0){
									$permissao=0;
								}
								$param = $conexao->prepare("INSERT INTO usuarios(usuario, nome,email,senha,permissao) VALUES (?, ?, ?, ?, ?)");
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
				endif;
			?>
			
			
			<form action="" method="POST" id="adicionausuario">
			<?php if($usuario=='root'){$usuario='';} ?>
				<label> Usuário: </label>
					<input type="text" placeholder="usuário" class="form-control" name="usuario" value=<?php echo "'". $usuario . "'"; ?> autofocus />
				<label> Nome: </label>
					<input type="text" placeholder="nome completo" class="form-control" name="nome" value=<?php echo "'". $nome . "'"; ?> />
				<label> E-mail: </label>
				<input type="text" placeholder="e-mail" class="form-control" name="email" value=<?php echo "'". $email . "'"; ?> />
				<label> Senha: </label>
					<input type="password" placeholder="senha" class="form-control" name="senha" id="senha"/>
				<label> Confirmar senha: </label>
					<input type="password" placeholder="repetir senha" class="form-control" name="senhaconfirma" />
				<label> Permissão: </label>
					<select class="form-control" name="permissao">
					  <option value="0" <?php if($permissao==0){ echo 'selected'; }  ?>>Visualizador</option>
					  <option value="1" <?php if($permissao==0){ echo 'selected'; }  ?>>Jogador</option>
					  <option value="2" <?php if($permissao==0){ echo 'selected'; }  ?>>Gestor</option>
					  <option value="3" <?php if($permissao==0){ echo 'selected'; }  ?>>Administrador</option>
					</select>
				<input type="submit" name="criar" value="Criar usuário" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>