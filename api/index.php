<?php


require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->post('/questaonova/', function () use ($app) {
    $json = $app->request->getBody();
    $data = json_decode($json, true); 
    $materia = $data['materia'];
    $serie = $data['serie'];
    $idGrupo = $data['idGrupos'];
    $perguntas = $data['pergunta'];
    $pergunta = '"'.$perguntas["questao"].'"';
    $respCert = '"'.$perguntas["respostaCorreta"].'"';
    $respAlts = $perguntas["respostasErradas"];
    $respAlt1 = '"'.$respAlts[0].'"';
    $respAlt2 = '"'.$respAlts[1].'"';
    $respAlt3 = '"'.$respAlts[2].'"';
    $professor = $data['professor']; 

include '../cms2/restrito/conexao.php';

$param = $conexao->prepare('INSERT INTO questoes(dificuldade, qtUso, qtAcert, qtErro, pergunta, altResp, alt1, alt2, alt3, anos_idAno, materia_idMateria, lingua) VALUES (1, 0, 0, 0, ?, ?, ?, ?, ?, ?, ?, "pt")');
						$param->bind_param('sssssii', $pergunta, $respCert, $respAlt1, $respAlt2, $respAlt3, $serie, $materia);
						if ($param->execute()) {
							echo '{ "status": 200}';
							$param->close();
						} else {
							echo '{ "status": 500}';
						}

$profparam = $conexao->prepare("UPDATE `professores` SET `pontos`=`pontos`+10,`qtPergCriad`=`qtPergCriad`+1 WHERE `usuario`=?");
$profparam->bind_param('s', $professor);
if($profparam->execute()){
  $profparam->close();
}


$aluparam = $conexao->prepare("UPDATE `alunos` SET `pontos`=`pontos`+10,`qtPergCriad`=`qtPergCriad`+1 WHERE `grupos_idGrupos`=?");
$aluparam->bind_param('s', $idGrupo);
if($aluparam->execute()){
  $aluparam->close();
}


});

// GET route
$app->get(
    '/estatisticas/equipes/aluno/:user',
    function ($user) {
                include '../cms2/restrito/conexao.php';
                $usuario = '"'.$user.'"';
                $resultado = $conexao->query("
                        SELECT `grupos_idGrupos`
                        FROM  `alunos`
                        WHERE  `usuario` =$usuario
                ");
                echo '
{
    "grupos": [
';
                $linha = $resultado->fetch_assoc();
                $valor=$linha['grupos_idGrupos'];
                $resultadoLinha = $conexao->query("
                        SELECT `usuario`, `nome`
                        FROM  `alunos`
                        WHERE  `grupos_idGrupos` = $valor
                ");
                $j=1;
                $sep2="";
                $usuariosLista="";
                $nomeLista="";
                while ($linhaInd = $resultadoLinha->fetch_assoc()){
                        if($j>1){ $sep2=",";}
                        $usuariosLista = $usuariosLista.$sep2.'"'.$linhaInd['usuario'].'"';
                        $nomeLista = $nomeLista.$sep2.'"'.$linhaInd['nome'].'"';
                        $j++;
                }
                echo '{
                        "idGrupo": '. $valor .',
                        "usuarios": ['.($usuariosLista).'],
                        "nomes": ['.($nomeLista).']
                }';

echo '
      ]
}
';
});







$app->get(
    '/estatisticas/equipes/professor/:user',
    function ($user) {
		include '../cms2/restrito/conexao.php';
		$usuario = '"'.$user.'"';
		$resultado = $conexao->query("
			SELECT `grupos_idGrupos`
			FROM  `ProfGrupos`
			WHERE  `professores_usuario` =$usuario
		");
		$i=1;
		$sep="";
		echo '
{
    "grupos": [
';

		while ($linha = $resultado->fetch_assoc()){
			$valor=$linha['grupos_idGrupos'];
                	if($i>1){ $sep=",";}
			$resultadoLinha = $conexao->query("
				SELECT `usuario`, `nome`
				FROM  `alunos`
				WHERE  `grupos_idGrupos` = $valor
			");
			$j=1;
			$sep2="";
			$usuariosLista="";
			$nomeLista="";
			while ($linhaInd = $resultadoLinha->fetch_assoc()){
				if($j>1){ $sep2=",";}
				$usuariosLista = $usuariosLista.$sep2.'"'.$linhaInd['usuario'].'"';
				$nomeLista = $nomeLista.$sep2.'"'.$linhaInd['nome'].'"';
				$j++;
			}
                        echo $sep;
			echo '{
				"idGrupo": '. $valor .',
				"usuarios": ['.($usuariosLista).'],
				"nomes": ['.($nomeLista).']
			}';
		$i++;
		}

echo '
      ]
}
';
});





$app->get(
    '/estatisticas/grupo/:idgrupo',
    function ($idgrupo) {

include '../cms2/restrito/conexao.php';
$resultado = $conexao->query("
SELECT `usuario`, `nome`
FROM  `alunos`
WHERE  `grupos_idGrupos` =$idgrupo
");
$i=1;
$sep="";
$usuariosLista="";
$nomeLista="";

while ($linha = $resultado->fetch_assoc()){
if($i>1){ $sep=",";}
$usuariosLista = $usuariosLista.$sep.'"'.$linha['usuario'].'"';
$nomeLista = $nomeLista.$sep.'"'.$linha['nome'].'"';
$i++;
}

echo '{
"usuarios": ['.($usuariosLista).'],
"nomes": ['.($nomeLista).']
}';
});




$app->get(
    '/estatisticas/aluno/:myuser',
    function ($myuser) {
include '../cms2/restrito/conexao.php';
$usuari = '"'.$myuser.'"';
$resultado = $conexao->query("
SELECT  `pontos` ,  `qtVit` ,  `qtDer` ,  `qtEmp` ,  `qtPart` ,  `qtPergCriad` 
FROM  `alunos` 
WHERE  `usuario` =$usuari
LIMIT 0 , 30
");
$linha = $resultado->fetch_assoc();


$pontos = (empty($linha['pontos'])) ? 0 : $linha['pontos'];
$quantidadeVitorias = (empty($linha['qtVit'])) ? 0 : $linha['qtVit'];
$quantidadeDerrotas = (empty($linha['qtDer'])) ? 0 : $linha['qtDer'];
$questoesEmpates = (empty($linha['qtEmp'])) ? 0 : $linha['qtEmp'];
$questoesPartidas = (empty($linha['qtPart'])) ? 0 : $linha['qtPart'];
$questoesCriadas = (empty($linha['qtPergCriad'])) ? 0 : $linha['qtPergCriad'];

echo '
{
  "pontuacao": '.$pontos.',
  "quantidadeVitorias": '.$quantidadeVitorias.',
  "quantidadeDerrotas": '.$quantidadeDerrotas.',
  "questoesEmpates": '.$questoesEmpates.',
  "questoesPartidas": '.$questoesPartidas.',
  "questoesCriadas": '.$questoesCriadas.'
}

';
});


$app->get(
    '/estatisticas/professor/:myuser',
    function ($myuser) {
include '../cms2/restrito/conexao.php';
$usuari = '"'.$myuser.'"';
$resultado = $conexao->query("
SELECT  `pontos` ,  `qtPergCriad`
FROM  `professores`
WHERE  `usuario` =$usuari
LIMIT 0 , 30
");
$linha = $resultado->fetch_assoc();

$pontos = (empty($linha['pontos'])) ? 0 : $linha['pontos'];
$questoesCriadas = (empty($linha['qtPergCriad'])) ? 0 : $linha['qtPergCriad'];

echo '
{
  "pontuacao": '.$pontos.',
  "questoesCriadas": '.$questoesCriadas.'
}

';
});



$app->get('/perguntas/:materia/:serie', function($materia, $serie) {
include '../cms2/restrito/conexao.php';
$resultado = $conexao->query("
SELECT * 
FROM  `questoes` 
WHERE  `materia_idMateria` =$materia AND `anos_IdAno` =$serie
LIMIT 0 , 20
");
$j = 1;

echo '{
"perguntas": [';


while ($linha = $resultado->fetch_assoc()){
if($j>1){
  echo ',';
}
echo '
        {
            "pergunta": {
                "idPergunta":' . $linha['idQuestoes'] . ',
                "pergunta": "' . $linha['pergunta'] . '",
                "respostaCorreta": "' . $linha['altResp'] . '",
                "respostasErradas": [
                    "' . $linha['alt1'] . '",
                    "' . $linha['alt2'] . '",
                    "' . $linha['alt3'] . '"
                ]
            }
        }  
';
   $j++;

}
echo '
    ]
}';
  
});

$app->get(
    '/',
    function () {
       echo 'Ola, esta eh a API do Jogo QvQ';
    }
);


$app->get(
    '/materias/:serie',
    function ($serie) {

include '../cms2/restrito/conexao.php';
$resultado = $conexao->query("
SELECT `materia_idMateria`,
COUNT(*)
FROM  `questoes`
WHERE  `anos_idAno` =$serie
GROUP BY `materia_idMateria`
");
$i=1;
$sep="";
$materiaLista="";
$qtdadeLista="";

while ($linha = $resultado->fetch_assoc()){
if($i>1){ $sep=",";}
$materiaLista = $materiaLista.$sep.$linha['materia_idMateria'];
$qtdadeLista = $qtdadeLista.$sep.$linha['COUNT(*)'];
$i++;
}

echo '{
"materias": ['.($materiaLista).'],
"quantidadeDeQuestoes": ['.($qtdadeLista).']
}';
});

// POST route
$app->post('/login/', function () use ($app) {
    $json = $app->request->getBody();
    $data = json_decode($json, true);
    $user = $data['usuario'];
    $pass = $data['senha'];

include '../cms2/restrito/conexao.php';
$usuario = '"'.$user.'"';
$resultado = $conexao->query("
SELECT senha 
FROM  `professores` 
WHERE `usuario`=$usuario
LIMIT 0 , 1
");

$linha = $resultado->fetch_assoc();

if(! $linha) {
   $permissao=1;

   $resultado = $conexao->query("
      SELECT senha 
      FROM  `alunos` 
      WHERE `usuario`=$usuario
      LIMIT 0 , 1
    ");

   $linha = $resultado->fetch_assoc();

} else {
   $permissao=2;
}
   if($linha['senha']==$pass) {
      echo ' 
 
{
	"usuario":' . $usuario . ',
	"nivelUsuario":' .  $permissao .'
}
';
   } else {
   echo '
        {
            "ErrorCode": 403,
            "ErrorMessage": "Forbidden"
        }
    ';
}
}
);



$app->post('/relatoriodejogo/', function () use ($app) {
    $json = $app->request->getBody();
    $data = json_decode($json, true);
    $professor = $data['userProf'];
    $idGrupos = $data['idGrupos'];
    $acertos = $data['acertos'];
    $erros = $data['erros'];
    $qtdade = count($idGrupos);

include '../cms2/restrito/conexao.php';

$pontos=$qtdade*10;
$profparam = $conexao->prepare("UPDATE `professores` SET `pontos`=`pontos`+$pontos WHERE `usuario`=?");
$profparam->bind_param('s', $professor);
if($profparam->execute()){
    echo '{ "status": 200}';
    $profparam->close();
} else {
    echo '{ "status": 500}';
}

for($i=0;$i<$qtdade-1;$i++) {
    $aluparam = $conexao->prepare("UPDATE `alunos` SET `pontos`=`pontos`+$acertos[$i],`qtVit`=`qtVit`+$acertos[$i], `qtDer`=`qtDer`+$erros[$i], `qtPart`=`qtPart`+$erros[$i]+$acertos[$i] WHERE `grupos_idGrupos`=?");
    $aluparam->bind_param('s', $idGrupos[$i]);
    if($aluparam->execute()){
      $aluparam->close();
    }
}

});


$app->run();
