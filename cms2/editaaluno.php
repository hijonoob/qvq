<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> Editar aluno </h3>
			
			<?php
				include 'restrito/conexao.php';
				$usuario = htmlspecialchars($_GET["usuario"]);
				if($usuario){

					if ($sql = $conexao->prepare("SELECT nome, dtNasc, email, telFixo, telCel, end, cid, est, cep, senha, grupos_idGrupos, anos_idAno FROM alunos WHERE usuario = ?")) {
						$sql->bind_param('s', $usuario);
						$sql->execute();
						$sql->bind_result($nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $grupos_idGrupos, $anos_idAno);
						$sql->fetch();
echo $nome;
echo "aqui o nome";
						if ($nome == ''){
							echo "<div class='alert alert-warning'> Aluno não encontrado </div>";
						} else {
							echo "<div class='alert alert-info'> Aluno encontrado: USUÁRIO ". $usuario . "</div>";
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
						echo "<div class='alert alert-warning'> Todos os campos devem ser preenchidos. </div>";
					} else {
						$param = $conexao->prepare("UPDATE alunos SET nome = ?, dtNasc = ?, email = ?, telFixo = ?, telCel = ?, end = ?, cid = ?, est = ?, cep = ?, senha = ?, grupos_idGrupos = ?, anos_idAno = ? WHERE usuario = ?");
						$param->bind_param('sisiisssssiis', $nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $grupos_idGrupos, $anos_idAno, $usuario);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> Alteração efetuada com sucesso. </div>";
							$param->close();
						}
					}
				endif;
			?>

			<form action="" method="POST" id="editaaluno">
				<label for="nome"> Nome: </label>
					<input type="text" placeholder="nome" class="form-control" name="nome" value=<?php echo "'". $nome . "'"; ?>/>
				<label for="dtNasc"> Data de Nascimento: </label>
					<input type="text" placeholder="data de nascimento" class="form-control" name="dtNasc" value=<?php echo "'". $dtNasc . "'"; ?>/>
				<label for="email"> E-mail: </label>
					<input type="text" placeholder="e-mail" class="form-control" name="email" value=<?php echo "'". $email . "'"; ?>/>
				<label for="telFixo"> Telefone fixo: </label>
					<input type="text" placeholder="telefone fixo" class="form-control" name="telFixo" value=<?php echo "'". $telFixo . "'"; ?>/>
				<label for="telCel"> Telefone celular: </label>
					<input type="text" placeholder="telefone celular" class="form-control" name="telCel" value=<?php echo "'". $telCel . "'"; ?>/>
				<label for="end"> Endereço: </label>
					<input type="text" placeholder="endereço completo" class="form-control" name="end" value=<?php echo "'". $end . "'"; ?>/>
				<label for="cid"> Cidade: </label>
					<input type="text" placeholder="cidade" class="form-control" name="cid" value=<?php echo "'". $cid . "'"; ?>/>
				<label for="est"> Estado: </label>
					<input type="text" placeholder="estado" class="form-control" name="est" value=<?php echo "'". $est . "'"; ?>/>
				<label for="cep"> CEP: </label>
					<input type="text" placeholder="cep" class="form-control" name="cep" value=<?php echo "'". $cep . "'"; ?> />
				<label for="senha"> Senha: </label>
					<input type="text" placeholder="senha para acesso de login" class="form-control" name="senha" value=<?php echo "'". $senha . "'"; ?>/>

				<label for="grupos_idGrupos"> Id do Grupo: </label>
					<input type="text" placeholder="id do grupo - padrão 1" class="form-control" name="grupos_idGrupos" value=<?php echo "'". $grupos_idGrupos . "'"; ?> />
				<label for="anos_idAno"> Id do Ano: </label>
					<input type="text" placeholder="Id de ano - apenas número" class="form-control" name="anos_idAno" value=<?php echo "'". $anos_idAno . "'"; ?>/>


				<input type="submit" name="editar" value="Editar aluno" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>
