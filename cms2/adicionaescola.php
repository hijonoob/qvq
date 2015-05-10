<?php
	include 'templates/checaadmin.php';
	include 'templates/header.php';
?>
			<h3> Adicionar escola </h3>
			
			<?php
				include 'restrito/conexao.php';
				if( isset( $_POST['criar'] ) ):
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
						echo "<div class='alert alert-warning'> Todos os campos devem ser preenchidos. </div>";
					} else {
						$param = $conexao->prepare("INSERT INTO escolas(usuario, perfil, nome, razao, cnpj, end, cid, est, cep, telFixo, contato, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$param->bind_param('ssssssssiiss', $usuario, $perfil, $nome, $razao, $cnpj, $end, $cid, $est, $cep, $telFixo, $contato, $senha);
						if ($param->execute()) {
							echo "<div class='alert alert-success'> Inclusão efetuada com sucesso. </div>";
							$param->close();
						}
					}
				endif;
			?>
			
			
			<form action="" method="POST" id="adicionaescola">
				<label for="usuario"> Usuário: </label>
					<input type="text" placeholder="usuário para login" class="form-control" name="usuario" autofocus />
				<label for="perfil"> Perfil: </label>
					<input type="text" placeholder="perfil de acesso ao CMS 2 para escola 3 para admin" class="form-control" name="perfil" />
				<label for="nome"> Nome: </label>
					<input type="text" placeholder="nome da escola" class="form-control" name="nome" />

				<label for="razao"> Razão social: </label>
					<input type="text" placeholder="razão social da escola" class="form-control" name="razao" />

				<label for="cnpj"> CNPJ: </label>
					<input type="text" placeholder="cnpj da escola" class="form-control" name="cnpj" />
				<label for="end"> Endereço: </label>
					<input type="text" placeholder="endereço completo da escola" class="form-control" name="end" />
				<label for="cid"> Cidade: </label>
					<input type="text" placeholder="cidade da escola" class="form-control" name="cid" />
				<label for="est"> Estado: </label>
					<input type="text" placeholder="estado da escola" class="form-control" name="est" />
				<label for="cep"> CEP: </label>
					<input type="text" placeholder="cep da escola" class="form-control" name="cep" />
				<label for="telFixo"> Telefone fixo: </label>
					<input type="text" placeholder="telefone fixo da escola" class="form-control" name="telFixo" />
				<label for="contato"> Nome do contato: </label>
					<input type="text" placeholder="nome do contato na escola" class="form-control" name="contato" />
				<label for="senha"> Senha: </label>
					<input type="text" placeholder="senha para acesso de login da escola" class="form-control" name="senha" />

				<input type="submit" name="criar" value="Adicionar escola" class="btn btn-default" />	
			</form>		
		</div>	

<?php include 'templates/footer.php' ?>

