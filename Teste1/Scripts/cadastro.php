<?php
include('conection.php');

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$tipocep = $_POST['tipocep'];
$cep = $_POST['cep'];
$uf = $_POST['uf'];
$cidade = $_POST['cidade'];
$bairro = $_POST['bairro'];
$rua = $_POST['rua'];
$numero = $_POST['numero'];
$complemento = $_POST['complemento'];

$cpfQuery = "select cpf from teste3 where cpf = '${cpf}'";
$cpfProcura = pg_query($conexao, $cpfQuery);
$cpfExiste  = pg_num_rows($cpfProcura);
// if($cpfExiste == 1){
//     echo ("<SCRIPT LANGUAGE='JavaScript'>
//         window.alert('O CPF: ${CPF} JÁ ESTÁ CADASTRADO!')
//         window.location.href='../index.html';
//         </SCRIPT>"
//     );
//     exit;
// }

$query = "insert into teste3 (nome, cpf, email, telefone) values ('${nome}','${cpf}','${email}','${telefone}') returning id";
$insere = pg_query($conexao, $query) or die ('Deu Merda cambada');
$idBusca = pg_query($conexao, 'select lastval()');
$idlinha = pg_fetch_row($idBusca);
$id = $idlinha[0];

echo $id;
if ($id > 0){
    for($x = 0; $x < $cep.count(); $x++){
        echo 'ola';
        $insereCep = pg_query($conexao, `insert into testeenderecos (tipo, cep, estado, cidade, bairro, rua, numero, complemento, teste_id) values ('$tipocep[$x]','$cep[$x]','$uf[$x]','$cidade[$x]','$bairro[$x]','$rua[$x]','$numero[$x]','$complemento[$x]','${id})`) or die ('Oque aconteceu aqui');
    }
    echo 'ual';
}

echo 'sucesso';
?>