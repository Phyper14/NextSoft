<?php
$conn = "host=localhost port=5432 dbname=usuario user=postgres password=Pablo14hsm";
$conexao = pg_connect($conn) or die ('nfoi');

echo "Conexão funciona \n\n";
?>