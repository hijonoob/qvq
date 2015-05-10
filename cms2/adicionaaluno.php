<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> Adicionar Aluno </h3>
			
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
					$escolas_idEscolas = $_POST['escolas_idEscolas'];
					$grupos_idGrupos = $_POST['grupos_idGrupos'];
					$anos_idAno = $_POST['anos_idAno'];
					
					if ($usuario=='' || $nome=='' || $dtNasc=='' || $email=='' || $telFixo=='' ||  $telCel=='' || $end=='' || $cid=='' || $est=='' || $cep=='' || $senha=='' || $escolas_idEscolas=='' || $grupos_idGrupos=='' || $anos_idAno=='') {
						echo "<div class='alert alert-warning'> Todos os campos devem ser preenchidos. </div>";
					} else {
						$param = $conexao->prepare("INSERT INTO alunos(usuario, nome, dtNasc, email, telFixo, telCel, end, cid, est, cep, senha, escolas_idEscolas, grupos_idGrupos, anos_idAno) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$param->bind_param('ssisiisssssiii', $usuario, $nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $escolas_idEscolas, $grupos_idGrupos, $anos_idAno);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> Inclusão efetuada com sucesso. </div>";
							$param->close();
						}
					}
				endif;
			?>
			
			
			<form action="" method="POST" id="adicionaluno">
				<label for="usuario"> Usuário: </label>
					<input type="text" placeholder="usuário para login" class="form-control" name="usuario" autofocus />
				<label for="nome"> Nome: </label>
					<input type="text" placeholder="nome" class="form-control" name="nome" />
				<label for="dtNasc"> Data de Nascimento: </label>
					<input type="text" placeholder="data de nascimento" class="form-control" name="dtNasc" />
				<label for="email"> E-mail: </label>
					<input type="text" placeholder="e-mail" class="form-control" name="email" />
				<label for="telFixo"> Telefone fixo: </label>
					<input type="text" placeholder="telefone fixo" class="form-control" name="telFixo" />
				<label for="telCel"> Telefone celular: </label>
					<input type="text" placeholder="telefone celular" class="form-control" name="telCel" />
				<label for="end"> Endereço: </label>
					<input type="text" placeholder="endereço completo" class="form-control" name="end" />
				<label for="cid"> Cidade: </label>
					<input type="text" placeholder="cidade" class="form-control" name="cid" />
				<label for="est"> Estado: </label>
					<input type="text" placeholder="estado" class="form-control" name="est" />
				<label for="cep"> CEP: </label>
					<input type="text" placeholder="cep" class="form-control" name="cep" />
				<label for="senha"> Senha: </label>
					<input type="text" placeholder="senha para acesso de login" class="form-control" name="senha" />


				<label for="escolas_idEscolas"> Id da Escola: </label>
					<input type="text" placeholder="id de escola" class="form-control" name="escolas_idEscolas" />
				<label for="grupos_idGrupos"> Id do Grupo: </label>
					<input type="text" placeholder="id do grupo - padrão 1" class="form-control" name="grupos_idGrupos" />
				<label for="anos_idAno"> Id do Ano: </label>
					<input type="text" placeholder="Id de ano - apenas número" class="form-control" name="anos_idAno" />

				<input type="submit" name="criar" value="Adicionar aluno" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>

