<?php

require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// GET route


$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

$app->get('/perguntas/:materia/:serie', function($materia, $serie) {
include '../cms/restrito/conexao.php';
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
echo 'aaaahhh';
include '../cms/restrito/conexao.php';
$resultado = $conexao->query("SELECT usuario FROM escolas");
$i = 1;
while ($linha = $resultado->fetch_assoc()){
	echo '<tr>';
	echo '<td>' . $i . '</td>'; // colocar número de repetição
	echo '<td>' . $linha['usuario'] .'</td>';
	echo '</tr>';
	$i++;
        echo 'hellow there';
    }
});



// POST route
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

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

$app->run();
