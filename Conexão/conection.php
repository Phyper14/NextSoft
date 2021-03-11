<?php

// Usei um banco de dados PostgresSQL, 
// mas existe uma possível alteração para mySQL alterando todas as funções "pg_" para "msqli_"

// Por motivos de segurança do github, removi as credenciais de acesso ao meu banco de dados.
// E criei um arquivo "credenciais.php" com elas, crie o mesmo e adicione as seguintes variáveis abaixo com a informação do seu banco de dados.
// $host = "Hostname do Banco";
// $port = "Porta usada";
// $dbname = "Nome do Banco de dados";
// $user = "Nome de usuário";
// $pass = "Senha do usuário";

include('credenciais.php');
$conn = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$tabelaUsuario = "usuarios";
$tabelaEndereco = "enderecos";

$conexao = pg_connect($conn) or die ('Não foi possível conectar ao banco de dados');

echo "Conexão funciona \n\n";
?>