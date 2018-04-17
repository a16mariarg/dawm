<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Búsqueda de términos</title>
</head>

<body>
    <form action="busqueda_terminos.php" method="get">

    <h1>Buscar términos</h1>
    Término a buscar: <input type="text" name="termino" size="30" autofocus="yes"><input type="submit" name="Buscar" value="Buscar término">
</form>
   <?php
    if(!empty($_GET['termino'])): // utiliza los dos puntos del if en vez de la llave
 // construimos la URL para acceder al servicio
 $url = 'http://es.wikipedia.org/w/api.php';
 $url .= '?action=query';
 $url .= '&list=search';
 $url .= '&format=xml';
 $url .= '&redirects';
 $url .= '&srsearch=' . urlencode($_GET['termino']);
 //buscamos páginas que coincidan con el término deseado
 $lista_paginas = file_get_contents($url);
 ?>
 <hr>
 <div>
 <h3>Listado de páginas con el término "<?php echo $_GET['termino']; ?>"</h3>
 <ul>
 <?php
 $xml = new SimpleXMLElement($lista_paginas);
 foreach($xml->query->search->children() as $pag) {
 $params = 'termino=' . $_GET['termino'];
 $params .= '&pag=' . urlencode($pag['title']);
 echo "<li><a href='?$params'>" . $pag['title'] . "</a></li>";
 }
 ?>
 </ul>
</div>
<?php endif; ?>  <!-- cierra el if. -->

<?php
 if(!empty($_GET['pag'])):
 $url = 'http://es.wikipedia.org/w/api.php';
 $url .= '?action=parse';
 $url .= '&prop=text';
 $url .= '&format=xml';
 $url .= '&redirects';
$url .= '&page=' . urlencode($_GET['pag']);
 $pagina = file_get_contents($url);
 ?>
 <hr>
 <div>
 <h3>Contenido de la página "<?php echo $_GET['pag']; ?>"</h3>
 <?php echo htmlspecialchars_decode($pagina); ?>
 </div>
 <?php endif; ?> <!-- cierra el if-->
</body>

</html>

