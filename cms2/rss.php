<?php
  header("Content-Type: application/xml; charset=utf-8");

  $details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
    <rss version="2.0">
     <channel>
      <title> Beetle Escape</title>
      <link> http://wwww.beetleescape.tk</link>
      <description> Últimas notícias do jogo Beetle Escape</description>
      <language> pt-br</language>';
  include 'restrito/conexao.php';

  $resultado = $conexao->query("SELECT id, titulo, autor, data FROM noticias ORDER BY data LIMIT 5");

  while($linha = $resultado->fetch_assoc()) {
   $items .= '<item>
    <title>'. $linha['titulo'] .'</title>
    <link>http://wwww.beetleescape.tk/noticia.php?id='. $linha['id'] .'</link>
    <description><![CDATA['. $linha['descricao'] .']]></description>
   </item>';
  } 
  $items .= '</channel>
    </rss>';
    echo $details;
    echo $items;
?>