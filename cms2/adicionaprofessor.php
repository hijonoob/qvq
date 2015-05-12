<?php
	include 'templates/checagestor.php';
	include 'templates/header.php';
?>
			<h3> Adicionar Professor </h3>
			
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
						echo "<div class='alert alert-warning'> Todos os campos devem ser preenchidos. </div>";
					} else {
                                                $hoje = date("Y-m-d");
						$param = $conexao->prepare("INSERT INTO professores(usuario, nome, dtNasc, email, telFixo, telCel, end, cid, est, cep, senha, escolas_idEscolas, dtReg, dtUltAces, pontos, qtPergCriad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 0)");
						$param->bind_param('ssisiisssssiss', $usuario, $nome, $dtNasc, $email, $telFixo, $telCel, $end, $cid, $est, $cep, $senha, $_SESSION['idEscolas'], $hoje, $hoje);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> Inclusão efetuada com sucesso. </div>";
							$param->close();
						}
					}
				endif;
			?>
			
			
			<form action="" method="POST" id="adicionprof">
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

				<input type="submit" name="criar" value="Adicionar professor" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>

