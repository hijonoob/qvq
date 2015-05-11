<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// GET route
$app->get('/perguntas/:materia/:serie', function($materia, $serie) {
include '../cms2/restrito/conexao.php';
$resultado = $conexao->query("
SELECT * 
FROM  `questoes` 
WHERE  `materia_idMateria` =$materia AND `anos_IdAno` =$serie
LIMIT 0 , 20
");
$i = 1;

echo '{
"perguntas": [';


while ($linha = $resultado->fetch_assoc()){
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
  if($i<2){
     echo ',';
  }
   $i++;

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
    '/serie/:materia',
    function ($materia) {

    }
);

// POST route
$app->get(
    '/login/:user/:pass', function($user, $pass) {
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

$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

$app->run();
