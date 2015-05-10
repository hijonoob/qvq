	</div>
	<div class="navbar navbar-default" role="navigation" id="anavegacao">
	  <div class="container">
	  	<ul id="acessibilidade" class="nav navbar-nav navbar-right">
			<li>
		        <a accesskey="1" href="#aconteudo" id="link-conteudo">
		            Ir para o conteúdo
		            <span>1</span>
		        </a>
		    </li>
		    <li>
		        <a accesskey="2" href="#anavegacao" id="link-navegacao">
		            Ir para o menu
		            <span>2</span>
		        </a>
		    </li>
		    <li class="last-item">
		        <a accesskey="3" href="#arodape" id="link-rodape">
		            Ir para o rodapé
		            <span>3</span>
		        </a>
		    </li>
		    <li id="acao-contraste">
		    	<a href="#" title="Alto Contraste" accesskey="4">
		    		Alto Contraste
		    	</a>
		    </li>
		</ul>

	    <a class="navbar-brand" href="index.php">Quiz VS Quiz</a>
	      <ul class="nav navbar-nav">

			<?php
			  if(isset($_SESSION['permissao'])) {
			      $permissao = $_SESSION['permissao'];
			      if($permissao > 0) {
			        include 'templates/menusempermissao.php';
			      } else {
				  	include 'templates/menulogin.php';
		      	  }
			  } else {
			  	include 'templates/menulogin.php';
	      	  }
			?>
	          
	      </ul>
	 </div>
	</div>
