<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> Editar usuário </h3>
			
			<?php
				include 'restrito/conexao.php';
				$usuario = htmlspecialchars($_GET["user"]);
				if($usuario){
					if ($sql = $conexao->prepare("SELECT nome, email, permissao FROM usuarios WHERE usuario = ?")) {
						$sql->bind_param('s', $usuario);
						$sql->execute();
						$sql->bind_result($nome, $email, $permissao);
						$sql->fetch();
						if ($nome == ''){
							echo "<div class='alert alert-warning'> Usuário não encontrado </div>";
						} else {
							echo "<div class='alert alert-info'> Usuário encontrado: ". $usuario . "</div>";
						}
						$sql->close();
					}
				}
				
				if( isset( $_POST['editar'] ) ):
					$nome = $_POST['nome'];
					$email = $_POST['email'];
					$permissao = $_POST['permissao'];
					
					if ($nome=='' || $email=='' || $permissao=='') {
						echo "<div class='alert alert-warning'> Todos os campos devem ser preenchidos. </div>";
					} else {
						if (!is_numeric ($permissao) || $permissao > 3 || $permissao < 0){
							$permissao=0;
						}
						$param = $conexao->prepare("UPDATE usuarios SET nome = ?,email = ?, permissao=? WHERE usuario = ?");
						$param->bind_param('ssis', $nome, $email, $permissao, $usuario);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> Alteração efetuada com sucesso. </div>";
							$param->close();
						}
					}
				endif;
			?>
			
			
			<form action="" method="POST" id="editausuario">
				<label> Nome: </label>
					<input type="text" placeholder="nome completo" class="form-control" name="nome" value=<?php echo "'". $nome . "'"; autofocus ?>/>
				<label> E-mail: </label>
				<input type="text" placeholder="e-mail" class="form-control" name="email" value=<?php echo "'". $email . "'"; ?>/>
				<label> Permissão: </label>
					<select class="form-control" name="permissao">
					  <option value="0" <?php if($permissao==0){ echo 'selected'; }  ?>>Visualizador</option>
					  <option value="1" <?php if($permissao==1){ echo 'selected'; }  ?>>Jogador</option>
					  <option value="2" <?php if($permissao==2){ echo 'selected'; }  ?>>Gestor</option>
					  <option value="3" <?php if($permissao==3){ echo 'selected'; }  ?>>Administrador</option>
					</select>
				<input type="submit" name="editar" value="Editar usuário" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>